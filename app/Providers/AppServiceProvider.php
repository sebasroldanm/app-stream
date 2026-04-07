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
        require_once app_path('Helpers/TelegramHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make('translator')->handleMissingKeysUsing(function ($key, $replacements, $locale) {
            \Illuminate\Support\Facades\Log::channel('language')->info("Missing translation key: [{$key}] for locale: [{$locale}]");
        });
    }
}
