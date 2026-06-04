<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:update-stat')->everyMinute();
Schedule::command('app:update-super-chat')->everyMinute();
Schedule::command('app:update-online --type=batch')->everyTwoMinutes();
Schedule::command('app:update-online --type=normal')->everyTenMinutes();
Schedule::command('app:update-favorites')->everyFiveMinutes();
Schedule::command('app:reload-timeline')->daily();