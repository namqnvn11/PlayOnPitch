<?php
ini_set('memory_limit', '-1');

use Illuminate\Support\Facades\Artisan;
Artisan::command('yard-schedule:create', function () {
    $this->info('Yard schedules have been created successfully!');
});
   // ->dailyAt('00:00');

Artisan::call('yard-schedule:create');
