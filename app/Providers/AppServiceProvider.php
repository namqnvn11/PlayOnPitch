<?php

namespace App\Providers;

use App\Models\Boss;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(env('APP_URL'));
        }

        ResetPassword::createUrlUsing(function ($user, string $token, string $broker = null) {
            // Lấy broker hiện tại hoặc mặc định
            $broker = $broker ?? Password::getDefaultDriver();
            Log::info($broker);

            // Lấy domain từ cấu hình
            $domain = config('app.url', env('APP_URL', 'https://playonpitch.online'));

            // Kiểm tra loại người dùng và tùy chỉnh URL
            if ($user instanceof Boss) {
                return $domain . '/boss/reset-password/' . $token . '?email='.$user->email;
            }

            // Nếu là User hoặc loại khác
            return $domain . '/reset-password/' . $token.'?email='.$user->email;
        });

    }
}
