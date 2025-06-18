<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {

            abort(403, 'Unauthorized.');

            // if ($guard === 'admin') {
            //     return redirect()->route('admin.login');
            // }

            // // Subdomain user hole
            // if ($request->route('subdomain')) {
            //     return redirect()->route('login', ['subdomain' => $request->route('subdomain')]);
            // }

            // Default user fallback
            // return redirect()->route('user.login', ['subdomain' => $request->route('subdomain')]);
        }

        return $next($request);
    }
}

