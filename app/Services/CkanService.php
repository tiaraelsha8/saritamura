<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\PendingRequest;
use Exception;
use Throwable;

class CkanService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;
    protected int $retryCount;
    protected int $retryDelay;

    public function __construct()
    {
        $this->baseUrl = config('ckan.api_url');
        $this->apiKey = config('ckan.api_key');
        $this->timeout = config('ckan.timeout');
        $this->retryCount = config('ckan.retry_count', 3);
        $this->retryDelay = config('ckan.retry_delay', 1000);
    }

    /**
     * Get HTTP Client with CKAN headers
     */
    protected function client(): PendingRequest
    {
        $client = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->timeout($this->timeout)
            ->asJson();

        // 🔐 Fix untuk HTTPS dengan self-signed certificate
        if (str_starts_with($this->baseUrl, 'https://') && config('app.env') !== 'production') {
            $client = $client->withOptions([
                'verify' => false,  // ⚠️ Hanya untuk development!
            ]);
        }

        return $client;
    }

    /**
     * Call CKAN API with retry logic
     */
    protected function callApi(string $action, array $params = [], bool $useCache = false, int $cacheTtl = 3600)
    {
        $cacheKey = "ckan_api_{$action}_" . md5(json_encode($params));

        if ($useCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->retryCount) {
            try {
                $response = $this->client()->post("{$this->baseUrl}/api/3/action/{$action}", $params);
                $result = $response->json();

                if ($response->successful() && isset($result['success']) && $result['success']) {
                    $data = $result['result'] ?? [];
                    if ($useCache) {
                        Cache::put($cacheKey, $data, $cacheTtl);
                    }
                    return $data;
                } else {
                    // 🔍 Handle empty error response []
                    $error = $result['error'] ?? null;

                    if (empty($error) || $error === []) {
                        // Empty error - try to get message from other fields
                        $errorMessage = $result['message'] ?? $result['help'] ?? $response->body() ?? 'Unknown CKAN error';
                        $errorType = $result['error_type'] ?? 'Unknown';
                    } elseif (is_array($error)) {
                        $errorMessage = json_encode($error);
                        $errorType = $error['__type'] ?? 'Unknown';
                    } else {
                        $errorMessage = (string) $error;
                        $errorType = 'Unknown';
                    }

                    Log::error('CKAN API Error', [
                        'action' => $action,
                        'error_type' => $errorType,
                        'error_detail' => $errorMessage,
                        'status' => $response->status(),
                        'params' => $params,
                        'raw_response' => $result,  // Log full response for debugging
                    ]);

                    throw new Exception("CKAN API [{$errorType}]: {$errorMessage}");
                }
            } catch (Throwable $e) {
                $lastException = $e;
                $attempts++;

                Log::warning('CKAN API Attempt Failed', [
                    'action' => $action,
                    'attempt' => $attempts,
                    'error' => $e->getMessage()
                ]);

                if ($attempts < $this->retryCount) {
                    usleep($this->retryDelay * 1000);
                }
            }
        }

        Log::error('CKAN API All Attempts Failed', [
            'action' => $action,
            'attempts' => $attempts,
            'error' => $lastException?->getMessage()
        ]);

        throw new Exception('CKAN API: ' . $lastException?->getMessage() ?? 'Unknown error', 0, $lastException);
    }

    /**
     * Get CKAN Status
     */
    public function getStatus(): array
    {
        return Http::timeout(5)->get("{$this->baseUrl}/api/3/action/status_show")->json();
    }

    /**
     * Search Packages (Datasets)
     */
    public function searchPackages(?string $query = '', array $params = []): array
    {
        // Convert null to empty string
        $query = $query ?? '';

        $defaultParams = [
            'q' => $query,
            'rows' => $params['rows'] ?? 12,
            'start' => $params['start'] ?? 0,
            'sort' => $params['sort'] ?? 'metadata_modified desc',
            'include_private' => false,
        ];

        return $this->callApi('package_search', array_merge($defaultParams, $params), true, 300);
    }

    /**
     * Get Package by ID or Name
     */
    public function getPackage(string $id): array
    {
        return $this->callApi('package_show', ['id' => $id], true, 600);
    }



    /**
     * Get List of Organizations
     */
    public function getOrganizations(): array
    {
        return $this->callApi('organization_list', [
            'all_fields' => true,
            'include_extras' => true,
        ], true, 3600);
    }

    /**
     * Get Organization Details
     */
    public function getOrganization(string $id): array
    {
        return $this->callApi('organization_show', [
            'id' => $id,
            'include_datasets' => true,
            'include_dataset_count' => true,
        ], true, 1800);
    }

    /**
     * Get List of Groups
     */
    public function getGroups(): array
    {
        return $this->callApi('group_list', [
            'all_fields' => true,
            'include_extras' => true,
        ], true, 3600);
    }

    /**
     * Get Resource by ID
     */
    public function getResource(string $id): array
    {
        return $this->callApi('resource_show', ['id' => $id], true, 600);
    }

    /**
     * Search DataStore (Query tabular data)
     */
    public function searchDataStore(string $resourceId, array $params = []): array
    {
        $defaultParams = [
            'resource_id' => $resourceId,
            'limit' => $params['limit'] ?? 100,
            'offset' => $params['offset'] ?? 0,
        ];

        if (isset($params['filters'])) {
            $defaultParams['filters'] = $params['filters'];
        }

        if (isset($params['fields'])) {
            $defaultParams['fields'] = $params['fields'];
        }

        return $this->callApi('datastore_search', $defaultParams, false, 0);
    }

    /**
     * Get DataStore fields/info for a resource
     */
    public function getDataStoreInfo(string $resourceId): array
    {
        try {
            // Get first record to infer schema
            $result = $this->searchDataStore($resourceId, [
                'limit' => 1,
                'include_total' => false,
            ]);

            return [
                'fields' => $result['fields'] ?? [],
                'records_count' => $result['total'] ?? 0,
                'active' => true,
            ];
        } catch (\Exception $e) {
            return [
                'active' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get Recent Changed Packages
     */
    public function getRecentPackages(int $limit = 6): array
    {
        try {
            return $this->callApi('recently_changed_packages', ['limit' => $limit], true, 300);
        } catch (\Exception $e) {
            // Fallback to package_search
            try {
                $result = $this->callApi('package_search', [
                    'rows' => $limit,
                    'sort' => 'metadata_modified desc',
                ], true, 300);

                return $result['results'] ?? [];
            } catch (\Exception $fallbackError) {
                Log::error('Recent packages fallback failed', [
                    'error' => $fallbackError->getMessage()
                ]);
                return [];
            }
        }
    }

    /**
     * Get Package Statistics
     */
    /**
     * Get Package Statistics (with robust fallback)
     */
    public function getStatistics(): array
    {
        try {
            $stats = $this->callApi('get_site_statistics', [], false, 0);
            if (isset($stats['package_count'])) {
                return $stats;
            }
        } catch (\Exception $e) {
            Log::info('get_site_statistics not available, using fallback', [
                'error' => $e->getMessage()
            ]);
        }

        // Fallback
        try {
            $packages = $this->callApi('package_search', ['rows' => 0], true, 300);
            $organizations = $this->callApi('organization_list', [
                'all_fields' => true,
                'include_extras' => true,
            ], true, 3600);

            return [
                'package_count' => $packages['count'] ?? 0,
                'organization_count' => count($organizations) ?? 0,
                'group_count' => 0,
                'resource_count' => 0,
            ];
        } catch (\Exception $fallbackError) {
            Log::error('Statistics fallback failed', [
                'error' => $fallbackError->getMessage()
            ]);

            return [
                'package_count' => 0,
                'organization_count' => 0,
                'group_count' => 0,
                'resource_count' => 0,
            ];
        }
    }

    /**
     * Create Package (Dataset)
     */
    public function createPackage(array $data): array
    {
        // Clear cache for organization stats
        Cache::forget('ckan_api_organization_list_*');

        return $this->callApi('package_create', $data, false, 0);
    }

    /**
     * Update Package
     */
    public function updatePackage(array $data): array
    {
        // Clear cache for this package
        Cache::forget("ckan_api_package_show_" . md5(json_encode(['id' => $data['id']])));

        return $this->callApi('package_update', $data, false, 0);
    }

    /**
     * Delete Package
     */
    public function deletePackage(string $id): array
    {
        Cache::forget("ckan_api_package_show_" . md5(json_encode(['id' => $id])));

        return $this->callApi('package_delete', ['id' => $id], false, 0);
    }

    /**
     * Create Resource
     */
    public function createResource(array $data): array
    {
        return $this->callApi('resource_create', $data, false, 0);
    }

    /**
     * Upload File to Resource (Multipart)
     */
    public function uploadResource(string $packageId, string $filePath, string $fileName, array $metadata = []): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])
            ->timeout(300)
            ->attach('upload', file_get_contents($filePath), $fileName)
            ->post("{$this->baseUrl}/api/3/action/resource_create", array_merge([
                'package_id' => $packageId,
                'name' => $fileName,
            ], $metadata));

        $result = $response->json();

        if (!$response->successful() || !($result['success'] ?? false)) {
            throw new Exception($result['error']['__type'] ?? 'Upload failed');
        }

        return $result['result'] ?? [];
    }

    /**
     * Delete Resource
     */
    public function deleteResource(string $id): array
    {
        Cache::forget("ckan_api_resource_show_" . md5(json_encode(['id' => $id])));

        return $this->callApi('resource_delete', ['id' => $id], false, 0);
    }

    /**
     * Get Tags
     */
    public function getTags(string $query = ''): array
    {
        return $this->callApi('tag_list', [
            'query' => $query,
            'all_fields' => true,
        ], true, 3600);
    }

    /**
     * Get Dataset Count by Organization
     */
    public function getDatasetCountByOrg(): array
    {
        $organizations = $this->getOrganizations();

        return collect($organizations)->map(function ($org) {
            return [
                'id' => $org['id'],
                'name' => $org['name'],
                'title' => $org['title'],
                'count' => $org['package_count'] ?? 0,
            ];
        })->sortByDesc('count')->values()->toArray();
    }

    /**
     * Health Check
     */
    public function healthCheck(): bool
    {
        try {
            $status = $this->getStatus();
            return isset($status['success']) && $status['success'];
        } catch (Exception $e) {
            Log::error('CKAN Health Check Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }


}
