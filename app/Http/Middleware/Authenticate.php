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
        $mainDomain = config('domains.main');

        if ($request->expectsJson()) {
            return null;
        }

        $host = $request->getHost();
        $hostWithoutWWW = preg_replace('/^www\./', '', $host); // Remove 'www.'

        // Admin domain check (with or without www)
        if ($hostWithoutWWW === $mainDomain) {
            return route('admin.login');
        }

        // Subdomain check
        if (preg_match('/^(.+)\.' . $mainDomain . '$/', $host, $matches)) {
            $sub = $matches[1];

            // Prevent 'www' subdomain being treated as user
            if ($sub !== 'www') {
                return route('user.login', ['subdomain' => $sub]);
            }
        }

        // Fallback
        return route('admin.login');
    }
}
