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
        Auth::shouldUse($guard);

        // dd($guard);

        $host = $request->getHost();
        $hostWithoutWWW = preg_replace('/^www\./', '', $host);
        $domain = config('domains.main');

        $isMainDomain = ($hostWithoutWWW === $domain);
        $isSubdomain = (!$isMainDomain && str_ends_with($host, '.'.$domain));
        // dd($guard, $host, $hostWithoutWWW, $domain, $isMainDomain, $isSubdomain, $type);

        if ($type === 'auth') {
            if (!Auth::guard($guard)->check()) {
                abort(403, 'Unauthorized');
            }
        }

        if ($type === 'guest') {
            if (Auth::guard($guard)->check()) {
                if ($isMainDomain && $guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                if ($isSubdomain && $guard === 'user') {
                    return redirect()->route('user.dashboard');
                }
            }
        }

        return $next($request);
    }

    // public function handle(Request $request, Closure $next, $type = 'auth', $guard = null)
    // {
    //     $domain = config('domains.main');
    //     $host = $request->getHost();
    //     $hostWithoutWWW = preg_replace('/^www\./', '', $host);

    //     $isMainDomain = $hostWithoutWWW === $domain;
    //     $isSubdomain = (!$isMainDomain && str_ends_with($host, '.' . $domain));

    //     // Force correct guard if not explicitly provided
    //     if ($guard === null) {
    //         if ($isMainDomain) {
    //             $guard = 'admin';
    //         } elseif ($isSubdomain) {
    //             $guard = 'web';
    //         }
    //     }

    //     // dd($guard, Auth::guard($guard)->check());

    //     // Logging for debug
    //     \Log::info("Using Guard: $guard");
    //     \Log::info("Auth Check for $guard: " . (Auth::guard($guard)->check() ? 'Yes' : 'No'));

    //     if ($type === 'auth' && !Auth::guard($guard)->check()) {
    //         abort(403, 'Unauthorized');
    //     }

    //     return $next($request);
    // }
}
