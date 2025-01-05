<?php

namespace App\Jobs;

use App\Mail\EmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $otpCode;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $otpCode)
    {
        $this->email = $email;
        $this->otpCode = $otpCode;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)->send(new EmailVerificationMail($this->otpCode));
    }
}
