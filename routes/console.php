<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('app:update-online')->everyFiveMinutes();
// Schedule::command('app:update-owners-data')->everyThirtyMinutes();
// Schedule::command('app:reload-timeline')->daily();