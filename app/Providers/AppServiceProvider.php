<?php

namespace App\Providers;

use App\Models\Goal;
use App\Observers\GoalObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/TelegramHelper.php');
        require_once app_path('Helpers/GeneralHelper.php');
        require_once app_path('Helpers/NumberHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Goal::observe(GoalObserver::class);
    }
}
