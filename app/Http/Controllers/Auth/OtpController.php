<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\SmsNetService;
use Carbon\Carbon;

class OtpController extends Controller {
    public function sendOtp(Request $request) {
        $request->validate(['phone' => 'required|digits:11']);

        // ✅ OTP তৈরি করো
        $otp = rand(100000, 999999);
        $user = User::updateOrCreate(
            ['phone' => $request->phone],
            ['otp' => $otp, 'otp_expires_at' => Carbon::now()->addMinutes(10)]
        );

        // ✅ SMS পাঠাও
        $smsService = new SmsNetService();
        $smsService->sendSms($user->phone, "Your OTP is: $otp");

        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function verifyOtp(Request $request) {
        $request->validate([
            'phone' => 'required|digits:11',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || $user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }

        // ✅ OTP Valid হলে সেট রিসেট করে Success দেখাও
        $user->update(['otp' => null, 'otp_expires_at' => null]);

        return response()->json(['message' => 'OTP Verified! Registration Successful.']);
    }
}
