<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

     public function sendOtp(Request $request) {

        dd('hello');
        // $request->validate(['phone_no' => 'required|digits:11']);

        // // ✅ OTP তৈরি করো
        // $otp = rand(100000, 999999);
        // $user = User::updateOrCreate(
        //     ['phone_no' => $request->phone_no],
        //     ['otp' => $otp, 'otp_expires_at' => Carbon::now()->addMinutes(10)]
        // );

        // // ✅ SMS পাঠাও
        // $smsService = new SmsNetService();
        // $smsService->sendSms($user->phone_no, "Your OTP is: $otp");

        // return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function verifyOtp(Request $request) {
        $request->validate([
            'phone_no' => 'required|digits:11',
            'otp' => 'required|digits:6',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::where('phone_no', $request->phone_no)->first();

        if (!$user || $user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }

        // ✅ OTP মিললে রেজিস্ট্রেশন সম্পন্ন করো
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return response()->json(['message' => 'Registration Successful!']);
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_no' => ['required', 'max:11', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
