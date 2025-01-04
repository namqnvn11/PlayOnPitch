<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpEmailJob;
use App\Mail\EmailVerificationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new OTP email for verification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('user.home.index', absolute: false));
        }

        $otpCode = rand(100000, 999999);
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        try {
            SendOtpEmailJob::dispatch($user->email, $user->otp_code);

        } catch (\Exception $e) {
            Log::error("Failed to send OTP email: " . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again later.']);
        }

        return back()->with('status', 'otp-sent');
    }
}
