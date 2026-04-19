<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $settings = Cache::rememberForever('system_settings', function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            // Set dynamic config
            if (isset($settings['site_name'])) {
                config(['app.name' => $settings['site_name']]);
            }

            View::share('system_settings', $settings);
        } catch (\Exception $e) {
            // Ignore in case table doesn't exist yet (e.g. during migrations)
            View::share('system_settings', []);
        }
    }
}
