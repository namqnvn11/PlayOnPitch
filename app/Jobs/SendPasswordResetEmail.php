<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class SendPasswordResetEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $role;

    /**
     * Create a new job instance.
     *
     * @param  string  $email
     * @return void
     */
    public function __construct(string $email,string $role)
    {
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $brokers = config('auth.passwords');
        if (!array_key_exists($this->role, $brokers)) {
            // Ghi log nếu broker không tồn tại
            logger()->error("Invalid broker role: {$this->role}");
            return;
        }
        Password::broker($this->role)->sendResetLink(['email' => $this->email]);
        Log::info("Send reset password email to: {$this->email}");
    }

}
