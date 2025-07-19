<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DomainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected string $mainDomain;
    protected DomainController $domainController;

    public function __construct()
    {
        $this->mainDomain = config('domains.main');
        $this->domainController = new DomainController;

    }

    public function create(): View
    {
        $host = request()->getHost();

        // Main domain or www subdomain
        if ($host === $this->mainDomain || $host === 'www.' . $this->mainDomain) {
            return view('admin.auth.login');
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // dd($credentials, $request->session());
        
        if ($this->domainController->isAdminDomain()) {
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        } else {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('user.dashboard', ['subdomain' => $this->domainController->getSubdomain()]));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        $guard = $this->domainController->isAdminDomain() ? 'admin' : 'web';

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $guard === 'admin'
            ? redirect()->route('admin.login')
            : redirect()->route('user.login', ['subdomain' => $this->domainController->getSubdomain()]);
    }

}
