<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Site settings saved in the database override the defaults in config/site.php.
        \App\Site\Settings::apply();

        // MCP endpoint: calls per minute per IP (config/mcp_site.php).
        \Illuminate\Support\Facades\RateLimiter::for('mcp', fn ($request) => \Illuminate\Cache\RateLimiting\Limit::perMinute(
            max(1, (int) config('mcp_site.rate_limit', 120))
        )->by($request->ip()));
    }
}
