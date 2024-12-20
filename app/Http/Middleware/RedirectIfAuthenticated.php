<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.boss.index');
        }

        if (Auth::guard('boss')->check()) {
            return redirect()->route('boss.yard.index');
        }

        if (Auth::guard('guest')->check()) {
            return redirect()->route('guest.home.index');
        }

        return $next($request);
    }
}
