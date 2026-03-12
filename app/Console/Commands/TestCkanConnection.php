<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CkanService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestCkanConnection extends Command
{
    protected $signature = 'ckan:test';
    protected $description = 'Test CKAN API Connection';

    public function handle(CkanService $ckan): int
    {
        $this->info('🔍 Testing CKAN Connection...');
        $this->line('CKAN URL: ' . config('ckan.api_url'));
        $this->line('API Key: ' . (config('ckan.api_key') ? 'Set' : 'Not Set'));
        $this->newLine();

        try {
            // Test 1: Status (public endpoint)
            $this->line('1. Checking status...');
            $status = Http::timeout(5)->get(config('ckan.api_url') . '/api/3/action/status_show')->json();

            if (isset($status['success']) && $status['success']) {
                $this->info('   ✅ Status OK');
                $this->line('   Site URL: ' . ($status['result']['site_url'] ?? 'N/A'));
                $this->line('   CKAN Version: ' . ($status['result']['ckan_version'] ?? 'N/A'));
            } else {
                $this->error('   ❌ Status Failed');
                return self::FAILURE;
            }

            $this->newLine();

            // Test 2: Package Search (public endpoint)
            $this->line('2. Testing package search...');
            $search = Http::withHeaders(['Authorization' => config('ckan.api_key')])
                ->timeout(10)
                ->post(config('ckan.api_url') . '/api/3/action/package_search', ['rows' => 1])
                ->json();

            if (isset($search['success']) && $search['success']) {
                $this->info('   ✅ Package Search OK');
                $this->line('   Total datasets: ' . ($search['result']['count'] ?? 0));
            } else {
                $this->warn('   ⚠️ Package Search Failed');
                $this->line('   Error: ' . json_encode($search['error'] ?? 'Unknown'));
            }

            $this->newLine();

            // Test 3: Organization List (needs API key)
            $this->line('3. Testing organization list...');
            $orgs = Http::withHeaders(['Authorization' => config('ckan.api_key')])
                ->timeout(10)
                ->post(config('ckan.api_url') . '/api/3/action/organization_list', ['all_fields' => true])
                ->json();

            if (isset($orgs['success']) && $orgs['success']) {
                $this->info('   ✅ Organization List OK');
                $this->line('   Total organizations: ' . count($orgs['result'] ?? []));
            } else {
                $this->warn('   ⚠️ Organization List Failed');
                $this->line('   Error: ' . json_encode($orgs['error'] ?? 'Unknown'));
            }

            $this->newLine();

            // Test 4: Site Statistics (might not exist)
            $this->line('4. Testing site statistics...');
            $stats = Http::withHeaders(['Authorization' => config('ckan.api_key')])
                ->timeout(10)
                ->post(config('ckan.api_url') . '/api/3/action/get_site_statistics')
                ->json();

            if (isset($stats['success']) && $stats['success']) {
                $this->info('   ✅ Site Statistics OK');
                $this->table(
                    ['Metric', 'Count'],
                    [
                        ['Datasets', $stats['result']['package_count'] ?? 0],
                        ['Organizations', $stats['result']['organization_count'] ?? 0],
                        ['Groups', $stats['result']['group_count'] ?? 0],
                        ['Resources', $stats['result']['resource_count'] ?? 0],
                    ]
                );
            } else {
                $this->warn('   ⚠️ Site Statistics Not Available (This is OK)');
                $this->line('   Alternative: Use package_search count instead');

                // Fallback: Get stats from package_search
                $this->info('   📊 Getting stats from alternative endpoints...');

                $datasets = $search['result']['count'] ?? 0;
                $organizations = count($orgs['result'] ?? []);

                $this->table(
                    ['Metric', 'Count'],
                    [
                        ['Datasets', $datasets],
                        ['Organizations', $organizations],
                        ['Groups', 'N/A'],
                        ['Resources', 'N/A'],
                    ]
                );
            }

            $this->newLine();
            $this->info('🎉 All tests completed!');
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Connection Failed: ' . $e->getMessage());
            $this->error('Debug: ' . $e->getTraceAsString());

            // Log full error
            Log::error('CKAN Test Failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return self::FAILURE;
        }
    }
}