<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:update-online --type=batch')->everyTwoMinutes();
Schedule::command('app:update-online --type=normal')->everyTenMinutes();
Schedule::command('app:update-favorites')->everyFiveMinutes();
Schedule::command('app:reload-timeline')->daily();