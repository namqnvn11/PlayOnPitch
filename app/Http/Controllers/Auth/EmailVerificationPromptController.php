<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpEmailJob;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('user.home.index', absolute: false));
        }
        try {
            $otpCode = rand(100000, 999999);
            $user = Auth::user();
            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);
            SendOtpEmailJob::dispatch($user->email, $user->otp_code);
            return view('auth.verify-email');
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email: " . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again later.']);
        }
    }
}
