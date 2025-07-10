<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // custom code
    public function create(): View
    {
        $host = request()->getHost();
    
        // if ($host === 'sazumme-tech-laravel.test') {
        if ($host === 'sazumme.com') {
            // Main domain - admin login view
            return view('admin.auth.login');
        }
    
        // Otherwise, assume subdomain user login
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (isAdminDomain()) {
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        } else {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('user.dashboard', ['subdomain' => $this->getSubdoamin()]));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    public function destroy(Request $request)
    {
        $guard = isAdminDomain() ? 'admin' : 'web';

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $guard === 'admin'
            ? redirect()->route('admin.login')
            : redirect()->route('user.login', ['subdomain' => $this->getSubdoamin()]);
    }

    private function getSubdoamin()
    {
        $host = request()->getHost();
        $parts = explode('.', $host);
        $subdomain = count($parts) > 2 ? $parts[0] : null;

        return $subdomain;
    }

    
}
