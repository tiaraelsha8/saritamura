<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CkanService;

class CkanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CkanService::class, function ($app) {
            return new CkanService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/ckan.php' => config_path('ckan.php'),
        ], 'ckan-config');
    }
}