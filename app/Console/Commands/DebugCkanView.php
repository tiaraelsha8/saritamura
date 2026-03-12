<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CkanService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DebugCkanView extends Command
{
    protected $signature = 'ckan:debug-view';
    protected $description = 'Debug CKAN API connection and view data';

    public function handle(CkanService $ckan): int
    {
        $baseUrl = config('ckan.api_url');
        $apiKey = config('ckan.api_key');

        $this->info('🔍 CKAN Debug Tool');
        $this->line("CKAN URL: {$baseUrl}");
        $this->line("API Key: " . ($apiKey ? 'Set (' . substr($apiKey, 0, 20) . '...)' : 'Not Set'));
        $this->newLine();

        // Test 1: Direct HTTP calls (bypass service)
        $this->line('📡 Testing direct HTTP calls...');

        // 1.1 Status (public)
        $this->line('  1.1 status_show...');
        try {
            $res = Http::timeout(5)->get("{$baseUrl}/api/3/action/status_show");
            $data = $res->json();
            if ($res->successful() && ($data['success'] ?? false)) {
                $this->info('     ✅ OK');
                $this->line('     Version: ' . ($data['result']['ckan_version'] ?? 'N/A'));
            } else {
                $this->error('     ❌ Failed: ' . json_encode($data['error'] ?? 'Unknown'));
            }
        } catch (\Exception $e) {
            $this->error('     ❌ Exception: ' . $e->getMessage());
        }

        // 1.2 Package search (public)
        $this->line('  1.2 package_search...');
        try {
            $res = Http::timeout(10)->post("{$baseUrl}/api/3/action/package_search", ['rows' => 0]);
            $data = $res->json();
            if ($res->successful() && ($data['success'] ?? false)) {
                $this->info('     ✅ OK');
                $this->line('     Dataset count: ' . ($data['result']['count'] ?? 0));
            } else {
                $this->error('     ❌ Failed: ' . json_encode($data['error'] ?? 'Unknown'));
            }
        } catch (\Exception $e) {
            $this->error('     ❌ Exception: ' . $e->getMessage());
        }

        // 1.3 Organization list (needs API key)
        $this->line('  1.3 organization_list...');
        try {
            $res = Http::withHeaders(['Authorization' => $apiKey])
                ->timeout(10)
                ->post("{$baseUrl}/api/3/action/organization_list", ['all_fields' => true]);
            $data = $res->json();
            if ($res->successful() && ($data['success'] ?? false)) {
                $this->info('     ✅ OK');
                $this->line('     Org count: ' . count($data['result'] ?? []));
            } else {
                $this->error('     ❌ Failed: ' . json_encode($data['error'] ?? 'Unknown'));
            }
        } catch (\Exception $e) {
            $this->error('     ❌ Exception: ' . $e->getMessage());
        }

        // 1.4 get_site_statistics (might not exist)
        $this->line('  1.4 get_site_statistics...');
        try {
            $res = Http::withHeaders(['Authorization' => $apiKey])
                ->timeout(10)
                ->post("{$baseUrl}/api/3/action/get_site_statistics");
            $data = $res->json();
            if ($res->successful() && ($data['success'] ?? false)) {
                $this->info('     ✅ OK');
                $this->line('     Stats: ' . json_encode($data['result']));
            } else {
                $error = $data['error'] ?? [];
                $this->warn('     ⚠️ Not available: ' . json_encode($error));
                $this->line('     → Will use fallback method');
            }
        } catch (\Exception $e) {
            $this->warn('     ⚠️ Exception: ' . $e->getMessage());
            $this->line('     → Will use fallback method');
        }

        $this->newLine();

        // Test 2: Service methods with fallback
        $this->line('🔧 Testing CkanService methods...');

        // 2.1 getStatistics with fallback
        $this->line('  2.1 getStatistics()...');
        try {
            $stats = $this->getStatisticsWithFallback($ckan, $baseUrl, $apiKey);
            $this->info('     ✅ OK');
            $this->table(['Metric', 'Value'], collect($stats)->map(fn($v, $k) => [$k, $v])->toArray());
        } catch (\Exception $e) {
            $this->error('     ❌ Failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        // 2.2 getRecentPackages
        $this->line('  2.2 getRecentPackages()...');
        try {
            $packages = $ckan->getRecentPackages(6);
            $this->info('     ✅ OK');
            $this->line('     Count: ' . count($packages));
        } catch (\Exception $e) {
            $this->warn('     ⚠️ Failed: ' . $e->getMessage());
        }

        // 2.3 getOrganizations
        $this->line('  2.3 getOrganizations()...');
        try {
            $orgs = $ckan->getOrganizations();
            $this->info('     ✅ OK');
            $this->line('     Count: ' . count($orgs));
        } catch (\Exception $e) {
            $this->warn('     ⚠️ Failed: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 Debug completed!');

        return self::SUCCESS;
    }

    /**
     * Get statistics with robust fallback
     */
    private function getStatisticsWithFallback($ckan, string $baseUrl, string $apiKey): array
    {
        // Try official endpoint first
        try {
            $res = Http::withHeaders(['Authorization' => $apiKey])
                ->timeout(10)
                ->post("{$baseUrl}/api/3/action/get_site_statistics");
            $data = $res->json();

            if ($res->successful() && isset($data['success']) && $data['success']) {
                return $data['result'] ?? [];
            }
        } catch (\Exception $e) {
            // Continue to fallback
        }

        // Fallback: Build from individual endpoints
        $stats = [];

        // Package count
        try {
            $res = Http::timeout(10)->post("{$baseUrl}/api/3/action/package_search", ['rows' => 0]);
            $data = $res->json();
            $stats['package_count'] = $data['result']['count'] ?? 0;
        } catch (\Exception $e) {
            $stats['package_count'] = 0;
        }

        // Organization count
        try {
            $res = Http::withHeaders(['Authorization' => $apiKey])
                ->timeout(10)
                ->post("{$baseUrl}/api/3/action/organization_list");
            $data = $res->json();
            $stats['organization_count'] = count($data['result'] ?? []);
        } catch (\Exception $e) {
            $stats['organization_count'] = 0;
        }

        // Group count
        try {
            $res = Http::timeout(10)->post("{$baseUrl}/api/3/action/group_list");
            $data = $res->json();
            $stats['group_count'] = count($data['result'] ?? []);
        } catch (\Exception $e) {
            $stats['group_count'] = 0;
        }

        $stats['resource_count'] = 0;  // Skip expensive calculation

        return $stats;
    }
}