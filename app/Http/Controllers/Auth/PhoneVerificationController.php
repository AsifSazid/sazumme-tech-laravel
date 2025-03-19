<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PhoneVerificationController extends Controller
{
    public function verifyPhone()
    {
        return view('auth.verify-phone');
    }
    
    public function sendOtp()
    {
        $phone_no = Auth::user()->phone_no;
    
        $otp = rand(100000, 999999); // ৬ ডিজিটের OTP
        Cache::put('otp_' . $phone_no, $otp, now()->addMinutes(5)); // ৫ মিনিটের জন্য OTP সংরক্ষণ
    
        // dd($otp);
        // SMS পাঠানোর API কল (sms.net.bd ব্যবহার করলে নিচের মতো করতে হবে)
        $api_key = "YOUR_API_KEY";
        $message = "Your OTP code is: " . $otp;
    
        // $sms_response = Http::get("https://sms.net.bd/api/send", [
        //     'api_key' => $api_key,
        //     'msg' => $message,
        //     'to' => $phone_no
        // ]);
    
        // if ($sms_response->successful()) {
        //     return response()->json(['message' => 'OTP sent successfully!']);
        // } else {
        //     return response()->json(['error' => 'Failed to send OTP.'], 500);
        // }

        return response()->json(['status' => 'otp-sent', 'code' => 'Your OTP is- '. $otp]);

    }
    // public function create()
    // {
    //     $request->validate([
    //         'phone_no' => 'required|digits:11' // বাংলাদেশের নম্বর ১১ ডিজিটের হয়
    //     ]);
    
    //     $otp = rand(100000, 999999); // ৬ ডিজিটের OTP
    //     Cache::put('otp_' . $request->phone_no, $otp, now()->addMinutes(5)); // ৫ মিনিটের জন্য OTP সংরক্ষণ
    
    //     // SMS পাঠানোর API কল (sms.net.bd ব্যবহার করলে নিচের মতো করতে হবে)
    //     $api_key = "YOUR_API_KEY";
    //     $message = "Your OTP code is: " . $otp;
    //     $phone = $request->phone_no;
    
    //     $sms_response = Http::get("https://sms.net.bd/api/send", [
    //         'api_key' => $api_key,
    //         'msg' => $message,
    //         'to' => $phone
    //     ]);
    
    //     if ($sms_response->successful()) {
    //         return response()->json(['message' => 'OTP sent successfully!']);
    //     } else {
    //         return response()->json(['error' => 'Failed to send OTP.'], 500);
    //     }


    //     return view('auth.verify-phone-no');
    // }

    public function verifyOtp(Request $request)
    {
        // dd($request->all());

        $user = Auth::user();

        $request->validate([
            'otp' => 'required|digits:6'
        ]);
    
        $storedOtp = Cache::get('otp_' . $user->phone_no);
    
        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json(['error' => 'Invalid OTP or expired.'], 422);
        }
    
        // OTP ঠিক থাকলে ক্যাশ থেকে মুছে ফেলুন
        Cache::forget('otp_' . $user->phone_no);

        $updatedUser = User::where('uuid', $user->uuid)->update([
            'is_phone_verified' => 1,
            'phone_verified_at' => now(),
        ]);
    
        return redirect()->route('dashboard');    
    }
}
