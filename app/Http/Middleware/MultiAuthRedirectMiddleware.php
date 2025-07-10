<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiAuthRedirectMiddleware
{
    public function handle(Request $request, Closure $next, $type = 'auth', $guard = null)
    {
        $guard = $guard ?? 'web';

        if ($type === 'auth') {
            // Block unauthenticated users
            if (!Auth::guard($guard)->check()) {
                abort(403, 'Unauthorized');
            }
        }

        if ($type === 'guest') {
            // Redirect logged-in users from guest routes
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
