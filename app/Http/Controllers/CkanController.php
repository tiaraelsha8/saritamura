<?php

namespace App\Http\Controllers;

use App\Services\CkanService;
use App\Http\Requests\StoreDatasetRequest;
use App\Http\Requests\UpdateDatasetRequest;
use App\Http\Requests\UploadResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Exception;

class CkanController extends Controller
{
    protected CkanService $ckan;

    public function __construct(CkanService $ckan)
    {
        $this->ckan = $ckan;
    }

    /**
     * Display homepage with CKAN data
     */
    public function index()
    {
        try {
            $stats = $this->ckan->getStatistics();
            $recentPackages = $this->ckan->getRecentPackages(6);
            $organizations = $this->ckan->getOrganizations();

            return view('ckan.index', compact('stats', 'recentPackages', 'organizations'));
        } catch (Exception $e) {
            Log::error('CKAN Index Error', ['error' => $e->getMessage()]);

            return view('ckan.index', [
                'error' => 'Gagal mengambil data dari CKAN: ' . $e->getMessage(),
                'stats' => [],
                'recentPackages' => [],
                'organizations' => [],
            ]);
        }
    }

    /**
     * Show create form
     */
    public function create()
    {
        try {
            $organizations = $this->ckan->getOrganizations();
            return view('ckan.create', compact('organizations'));
        } catch (Exception $e) {
            return redirect()->route('ckan.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store dataset to CKAN
     */
    public function store(StoreDatasetRequest $request)
    {
        try {
            $validated = $request->validated();

            // Prepare data for CKAN
            $data = [
                'name' => $validated['name'],
                'title' => $validated['title'],
                'notes' => $validated['notes'],
                'owner_org' => $validated['owner_org'],
                'license_id' => $validated['license_id'] ?? null,
                'private' => $validated['private'] ?? false,
            ];

            // Process tags
            if (!empty($validated['tags'])) {
                $tagNames = array_map('trim', explode(',', $validated['tags']));
                $data['tags'] = array_map(fn($name) => ['name' => $name], $tagNames);
            }

            // Process resources
            if (!empty($validated['resources'])) {
                $data['resources'] = collect($validated['resources'])
                    ->filter(fn($r) => !empty($r['name']))
                    ->map(fn($r) => [
                        'name' => $r['name'],
                        'url' => $r['url'] ?? null,
                        'format' => $r['format'] ?? 'CSV',
                        'description' => $r['description'] ?? null,
                    ])
                    ->toArray();
            }

            // Process extras
            if (!empty($validated['extras'])) {
                $data['extras'] = collect($validated['extras'])
                    ->filter(fn($e) => !empty($e['key']) && !empty($e['value']))
                    ->values()
                    ->toArray();
            }

            // Create package in CKAN
            $result = $this->ckan->createPackage($data);

            // Handle file uploads
            if ($request->hasFile('resources')) {
                foreach ($request->file('resources') as $index => $resourceFiles) {
                    if (isset($resourceFiles['upload']) && $resourceFiles['upload']->isValid()) {
                        $file = $resourceFiles['upload'];
                        $this->ckan->uploadResource(
                            $result['id'],
                            $file->getRealPath(),
                            $file->getClientOriginalName(),
                            ['name' => $data['resources'][$index]['name'] ?? $file->getClientOriginalName()]
                        );
                    }
                }
            }

            return redirect()->route('ckan.show', $result['id'])
                ->with('success', 'Dataset berhasil dibuat!');

        } catch (Exception $e) {
            Log::error('Failed to create dataset', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()->withInput()
                ->with('error', 'Gagal membuat dataset: ' . $e->getMessage());
        }
    }

    /**
     * Display dataset detail
     */
    public function show(string $id)
    {
        try {
            $package = $this->ckan->getPackage($id);
            return view('ckan.show', compact('package'));
        } catch (Exception $e) {
            abort(404, 'Dataset tidak ditemukan');
        }
    }

    /**
     * Show edit form
     */
    public function edit(string $id)
    {
        try {
            $package = $this->ckan->getPackage($id);
            $organizations = $this->ckan->getOrganizations();
            return view('ckan.edit', compact('package', 'organizations'));
        } catch (Exception $e) {
            return redirect()->route('ckan.index')
                ->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Update dataset
     */
    public function update(UpdateDatasetRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            $data = [
                'id' => $id,
                'title' => $validated['title'],
                'notes' => $validated['notes'],
                'owner_org' => $validated['owner_org'],
                'license_id' => $validated['license_id'] ?? null,
                'private' => $validated['private'] ?? false,
            ];

            $this->ckan->updatePackage($data);

            return redirect()->route('ckan.show', $id)
                ->with('success', 'Dataset berhasil diupdate!');

        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mengupdate dataset: ' . $e->getMessage());
        }
    }

    /**
     * Delete dataset
     */
    public function destroy(string $id)
    {
        try {
            $this->ckan->deletePackage($id);
            return redirect()->route('ckan.index')
                ->with('success', 'Dataset berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus dataset: ' . $e->getMessage());
        }
    }

    /**
     * Search datasets
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            $page = $request->input('page', 1);
            $rows = 12;

            $result = $this->ckan->searchPackages($query, [
                'rows' => $rows,
                'start' => ($page - 1) * $rows,
            ]);

            return view('ckan.search', [
                'packages' => $result['results'],
                'count' => $result['count'],
                'query' => $query,
                'page' => $page,
                'totalPages' => ceil($result['count'] / $rows),
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mencari dataset: ' . $e->getMessage());
        }
    }

    /**
     * Upload resource to dataset
     */
    public function uploadResource(UploadResourceRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $result = $this->ckan->uploadResource(
                    $validated['package_id'],
                    $file->getRealPath(),
                    $file->getClientOriginalName(),
                    [
                        'name' => $validated['name'],
                        'format' => $validated['format'],
                        'description' => $validated['description'] ?? null,
                    ]
                );
            } else {
                $result = $this->ckan->createResource([
                    'package_id' => $validated['package_id'],
                    'name' => $validated['name'],
                    'url' => $validated['url'],
                    'format' => $validated['format'],
                    'description' => $validated['description'] ?? null,
                ]);
            }

            return redirect()->route('ckan.show', $validated['package_id'])
                ->with('success', 'Resource berhasil diupload!');

        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal upload resource: ' . $e->getMessage());
        }
    }

    /**
     * Query DataStore
     */
    public function queryDataStore(string $resourceId, Request $request)
    {
        try {
            $result = $this->ckan->searchDataStore($resourceId, [
                'limit' => $request->input('limit', 100),
                'offset' => $request->input('offset', 0),
                'filters' => $request->input('filters', []),
            ]);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get organizations list
     */
    public function organizations()
    {
        try {
            $organizations = $this->ckan->getOrganizations();
            return view('ckan.organizations', compact('organizations'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengambil data organisasi');
        }
    }

    /**
     * Get organization detail
     */
    public function showOrganization(string $id)
    {
        try {
            $organization = $this->ckan->getOrganization($id);
            return view('ckan.organization', compact('organization'));
        } catch (Exception $e) {
            abort(404, 'Organisasi tidak ditemukan');
        }
    }

    /**
     * API: Health check
     */
    public function health()
    {
        $healthy = $this->ckan->healthCheck();

        return response()->json([
            'status' => $healthy ? 'healthy' : 'unhealthy',
            'ckan_url' => config('ckan.api_url'),
            'timestamp' => now()->toIso8601String(),
        ], $healthy ? 200 : 503);
    }

    /**
     * Menampilkan dataset
     */
    public function datasets(Request $request)
    {
        \Log::info('=== DATASETS FILTER DEBUG ===', [
            'all_params' => $request->all(),
            'organizations' => $request->input('organizations'),
            'q' => $request->input('q'),
            'sort' => $request->input('sort'),
        ]);
        try {
            $query = $request->input('q', '');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $sort = $request->input('sort', 'metadata_modified desc');

            // ✅ Get filter arrays
            $organizations = $request->input('organizations', []);
            $tags = $request->input('tags', []);
            $formats = $request->input('format', []);

            // Ensure arrays
            if (!is_array($organizations))
                $organizations = [$organizations];
            if (!is_array($tags))
                $tags = [$tags];
            if (!is_array($formats))
                $formats = [$formats];

            // Build CKAN search params
            $searchParams = [
                'q' => $query,
                'rows' => $perPage,
                'start' => ($page - 1) * $perPage,
                'sort' => $sort,
            ];

            // ✅ Build filter query (fq) for CKAN
            $filterQueries = [];

            // Organization filter
            if (!empty($organizations)) {
                $orgFilter = collect($organizations)
                    ->filter()  // Remove empty values
                    ->map(fn($org) => sprintf('organization:"%s"', $org))
                    ->implode(' OR ');

                if ($orgFilter) {
                    $filterQueries[] = sprintf('(%s)', $orgFilter);
                }
            }

            // Tags filter
            if (!empty($tags)) {
                $tagFilter = collect($tags)
                    ->filter()
                    ->map(fn($tag) => sprintf('tags:"%s"', $tag))
                    ->implode(' OR ');

                if ($tagFilter) {
                    $filterQueries[] = sprintf('(%s)', $tagFilter);
                }
            }

            // Format filter
            if (!empty($formats)) {
                $formatFilter = collect($formats)
                    ->filter()
                    ->map(fn($fmt) => sprintf('res_format:"%s"', $fmt))
                    ->implode(' OR ');

                if ($formatFilter) {
                    $filterQueries[] = sprintf('(%s)', $formatFilter);
                }
            }

            // Combine all filters
            if (!empty($filterQueries)) {
                $searchParams['fq'] = implode(' AND ', $filterQueries);

                // Log for debugging
                \Log::info('CKAN Filter Query', [
                    'fq' => $searchParams['fq'],
                    'organizations' => $organizations,
                    'tags' => $tags,
                ]);
            }

            // Fetch from CKAN
            $result = $this->ckan->searchPackages($query, $searchParams);

            // Transform datasets
            $datasets = collect($result['results'] ?? [])->map(function ($pkg) {
                return [
                    'id' => $pkg['id'],
                    'name' => $pkg['name'],
                    'title' => $pkg['title'] ?? $pkg['name'],
                    'notes' => Str::limit($pkg['notes'] ?? 'Tidak ada deskripsi', 200),
                    'organization' => $pkg['organization'] ?? null,
                    'license_id' => $pkg['license_id'] ?? null,
                    'private' => $pkg['private'] ?? false,
                    'resources' => $pkg['resources'] ?? [],
                    'tags' => $pkg['tags'] ?? [],
                    'metadata_modified' => $pkg['metadata_modified'] ?? null,
                ];
            });

            // Get organizations for filter sidebar
            $organizationsList = $this->ckan->getOrganizations();

            // Get popular tags
            $popularTags = [];
            try {
                $tagsResult = $this->ckan->getTags();
                $popularTags = collect($tagsResult)
                    ->sortByDesc('count')
                    ->take(10)
                    ->values()
                    ->toArray();
            } catch (\Exception $e) {
                // Tags optional
            }

            return view('ckan.datasets', [
                'datasets' => $datasets,
                'pagination' => [
                    'total' => $result['count'] ?? 0,
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'last_page' => ceil(($result['count'] ?? 0) / $perPage),
                    'from' => ($page - 1) * $perPage + 1,
                    'to' => min($page * $perPage, $result['count'] ?? 0),
                ],
                'filters' => [
                    'q' => $query,
                    'organizations' => $organizations,
                    'tags' => $tags,
                    'formats' => $formats,
                    'sort' => $sort,
                    'per_page' => $perPage,
                ],
                'organizations' => $organizationsList,
                'popularTags' => $popularTags,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to load datasets', [
                'error' => $e->getMessage(),
                'params' => $request->all()
            ]);

            return view('ckan.datasets', [
                'datasets' => collect(),
                'pagination' => ['total' => 0, 'current_page' => 1, 'last_page' => 1, 'from' => 0, 'to' => 0],
                'filters' => $request->all(),
                'organizations' => [],
                'popularTags' => [],
                'error' => 'Gagal memuat dataset: ' . $e->getMessage(),
            ]);
        }
    }

    public function trackView(string $id)
    {
        try {
            // Increment view count di CKAN (jika didukung)
            // Atau track di database lokal Anda

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show data preview modal/page for a resource
     */
    public function previewData(string $datasetId, string $resourceId, Request $request)
    {
        try {
            // Get resource details
            $resource = $this->ckan->getResource($resourceId);
            $package = $this->ckan->getPackage($datasetId);

            // Get DataStore info
            $datastoreInfo = null;
            try {
                // Check if resource has DataStore
                $datastoreInfo = $this->ckan->searchDataStore($resourceId, [
                    'limit' => 0,  // Just get metadata, no records
                    'include_total' => true,
                ]);
            } catch (\Exception $e) {
                // DataStore not available for this resource
            }

            return view('ckan.preview', [
                'package' => $package,
                'resource' => $resource,
                'datastoreInfo' => $datastoreInfo,
                'hasDataStore' => $resource['datastore_active'] ?? !empty($datastoreInfo),
            ]);

        } catch (\Exception $e) {
            Log::error('Preview data error', [
                'datasetId' => $datasetId,
                'resourceId' => $resourceId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('ckan.show', $datasetId)
                ->with('error', 'Gagal memuat preview data: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint: Return DataStore data as JSON for AJAX loading
     */
    public function apiGetData(string $datasetId, string $resourceId, Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $limit = min($request->input('limit', 100), 1000);  // Max 1000 records
            $offset = ($page - 1) * $limit;
            $sort = $request->input('sort', '');
            $filters = $request->input('filters', []);
            $search = $request->input('search', '');

            // Build search params
            $params = [
                'resource_id' => $resourceId,
                'limit' => $limit,
                'offset' => $offset,
                'include_total' => true,
                'records_format' => 'objects',  // or 'lists'
            ];

            // Add sort
            if (!empty($sort)) {
                $params['sort'] = $sort;
            }

            // Add filters (DataStore SQL-like filters)
            if (!empty($filters)) {
                $params['filters'] = $filters;
            }

            // Add full-text search
            if (!empty($search)) {
                $params['full_text'] = $search;
            }

            // Fetch from CKAN DataStore
            $result = $this->ckan->searchDataStore($resourceId, $params);

            return response()->json([
                'success' => true,
                'data' => $result['records'] ?? [],
                'fields' => $result['fields'] ?? [],
                'pagination' => [
                    'total' => $result['total'] ?? 0,
                    'page' => $page,
                    'limit' => $limit,
                    'total_pages' => ceil(($result['total'] ?? 0) / $limit),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('API get data error', [
                'resourceId' => $resourceId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Search datasets via AJAX (auto-search)
     */
    public function apiSearch(Request $request)
    {
        try {
            $query = $request->input('q');

            // ✅ FIX: Try multiple formats for "all datasets"
            if ($query === null || $query === '' || $query === '*') {
                // Try empty string first (most compatible)
                $query = '';
            }

            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $sort = $request->input('sort', 'metadata_modified desc');

            // Get filters
            $organizations = $request->input('organizations', []);
            $tags = $request->input('tags', []);

            if (!is_array($organizations))
                $organizations = [$organizations];
            if (!is_array($tags))
                $tags = [$tags];

            $organizations = array_filter($organizations);
            $tags = array_filter($tags);

            // Build search params
            $searchParams = [
                'rows' => $perPage,
                'start' => ($page - 1) * $perPage,
                'sort' => $sort,
            ];

            // ✅ FIX: Only add 'q' if it's not empty
            // Some CKAN instances don't like q='' or q='*'
            if ($query !== '' && $query !== '*') {
                $searchParams['q'] = $query;
            }
            // If query is empty, we DON'T send 'q' parameter at all
            // This tells CKAN to return ALL datasets

            // Build organization filter
            if (!empty($organizations)) {
                $orgFilter = collect($organizations)
                    ->map(fn($name) => sprintf('organization:"%s"', $name))
                    ->implode(' OR ');
                $searchParams['fq'] = "($orgFilter)";
            }

            // Debug log
            \Log::info('API Search', [
                'original_query' => $request->input('q'),
                'final_query' => $searchParams['q'] ?? '(not sent)',
                'fq' => $searchParams['fq'] ?? null,
                'full_params' => $searchParams,
            ]);

            // Fetch from CKAN
            $result = $this->ckan->searchPackages('', $searchParams);

            // Transform for JSON
            $datasets = collect($result['results'] ?? [])->map(function ($pkg) {
                return [
                    'id' => $pkg['id'],
                    'name' => $pkg['name'],
                    'title' => $pkg['title'] ?? $pkg['name'],
                    'notes' => Str::limit($pkg['notes'] ?? 'Tidak ada deskripsi', 200),
                    'organization' => $pkg['organization'] ?? null,
                    'license_id' => $pkg['license_id'] ?? null,
                    'license_title' => $pkg['license_title'] ?? null,
                    'private' => $pkg['private'] ?? false,
                    'resources' => $pkg['resources'] ?? [],
                    'tags' => $pkg['tags'] ?? [],
                    'metadata_modified' => $pkg['metadata_modified'] ?? null,
                    'metadata_views' => $pkg['metadata_views'] ?? 0,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $datasets,
                'pagination' => [
                    'total' => $result['count'] ?? 0,
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'last_page' => ceil(($result['count'] ?? 0) / $perPage),
                    'from' => ($page - 1) * $perPage + 1,
                    'to' => min($page * $perPage, $result['count'] ?? 0),
                ],
                'query' => '',
            ]);

        } catch (\Exception $e) {
            \Log::error('API Search error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * API: Auto-complete search suggestions
     */
    public function apiAutocomplete(Request $request)
    {
        try {
            $query = $request->input('q', '');
            $limit = min($request->input('limit', 10), 15);


            if (strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'suggestions' => [],
                ]);
            }

            // Search datasets matching query
            $searchParams = [
                'q' => $query,
                'rows' => $limit,
                'start' => 0,
                'sort' => 'metadata_modified desc',
                'fl' => 'id,name,title,organization',  // Only fetch needed fields
            ];

            $result = $this->ckan->searchPackages($query, $searchParams);

            // Transform to suggestions
            $suggestions = collect($result['results'] ?? [])->map(function ($pkg) {
                return [
                    'id' => $pkg['id'],
                    'title' => $pkg['title'] ?? $pkg['name'],
                    'name' => $pkg['name'],
                    'organization' => $pkg['organization']['title'] ?? $pkg['organization']['name'] ?? null,
                    'type' => 'dataset',
                ];
            })->take($limit)->toArray();

            return response()->json([
                'success' => true,
                'suggestions' => $suggestions,
                'query' => $query,
            ]);

        } catch (\Exception $e) {
            \Log::error('API Autocomplete error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}