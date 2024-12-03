<?php

namespace App\Jobs;

use App\Models\YardSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExpireReservationJob implements ShouldQueue
{
    use Queueable;
    protected $scheduleId;
    /**
     * Create a new job instance.
     */
    public function __construct($scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $schedule=YardSchedule::find($this->scheduleId);
        if ($schedule&&$schedule->status=='pending') {
            $schedule->status='available';
            $schedule->reservation_id=0;
            $schedule->save();
            Log::info('change pending status to available on'.$this->scheduleId);
        }
    }
}
