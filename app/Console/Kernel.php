<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Định nghĩa các lệnh Artisan tuỳ chỉnh.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Định nghĩa lịch trình các tác vụ cần chạy.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Thực hiện lệnh mỗi ngày vào lúc 00:00
        $schedule->command('generate:data')->dailyAt('00:00');
    }

}
