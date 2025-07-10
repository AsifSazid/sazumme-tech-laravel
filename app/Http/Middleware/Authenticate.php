<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // If request is for admin domain
        if ($request->getHost() === 'sazumme-tech-laravel.test') {
            return route('admin.login');
        }

        // If it's subdomain for user
        if (preg_match('/^(.+)\.sazumme-tech-laravel\.test$/', $request->getHost(), $matches)) {
            return route('user.login', ['subdomain' => $matches[1]]);
        }

        // Default fallback (if necessary)
        return route('user.login', ['subdomain' => 'www']);
    }
}
