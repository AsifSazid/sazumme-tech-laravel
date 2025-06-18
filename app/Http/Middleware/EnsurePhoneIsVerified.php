<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
    
        $fullHost = $request->getHost(); // e.g. publication.sazumme-tech-laravel.test
        $subdomain = explode('.', $fullHost)[0];
    
        if ($user && !$user->is_phone_verified) {
            return redirect()->route('user.verify.phone', ['subdomain' => $subdomain]);
        }
    
        return $next($request);
    }
}
