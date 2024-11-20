<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;


//Schedule::command('app:create-yard-schedules')->daily();
Schedule::command('app:create-yard-schedules')->everyMinute();
