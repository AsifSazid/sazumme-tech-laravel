<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('userHasRole')) {
    /**
     * Check if the currently authenticated user has a specific role
     *
     * @param string $roleName
     * @return bool
     */
    
    function userHasRole(string $roleName): bool
    {
        if (!Auth::check()) {
            return false;
        }

        // Assuming roles is a hasMany relationship returning a collection
        return Auth::user()->roles->contains('name', $roleName);
    }
}
