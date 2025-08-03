<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DomainController;
use App\Models\User;
use App\Models\UserWing;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $domainController = new DomainController;
        $wing = $domainController->getWingInfos();
        // dd($wing);
    
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone_no' => ['required', 'max:11'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Step 1: Check if user exists
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            // User doesn't exist → create user
            $user = User::create([
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => Hash::make($request->password),
            ]);
        }
    
        // Step 2: Check if UserWing exists for this user + wing
        $existingUserWithWing = UserWing::where('user_id', $user->id)
            ->where('wing_id', $wing->wing_id)
            ->first();
    
        if (!$existingUserWithWing) {
            UserWing::create([
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'user_id' => $user->id,
                'user_uuid' => $user->uuid,
                'wing_id' => $wing->id,
                'wing_uuid' => $wing->uuid,
                'wing_title' => $wing->title,
            ]);
        }
    
        // Trigger event and login
        event(new Registered($user));

        Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
        return redirect()->intended(route('user.dashboard', ['subdomain' => $this->domainController->getSubdomain()]));
    }
    
}
