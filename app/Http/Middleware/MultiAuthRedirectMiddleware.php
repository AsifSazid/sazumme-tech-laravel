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
    
        $host = $request->getHost();
        $hostWithoutWWW = preg_replace('/^www\./', '', $host);
        $domain = config('domains.main');
    
        $isMainDomain = ($hostWithoutWWW === $domain);
        $isSubdomain = (!$isMainDomain && str_ends_with($host, '.'.$domain));
    
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
    
}
