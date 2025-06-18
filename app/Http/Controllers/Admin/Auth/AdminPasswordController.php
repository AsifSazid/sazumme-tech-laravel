<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPasswordController extends Controller
{
    public function edit()
    {
        return view('admin.auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $admin = auth('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password changed successfully.');
    }
}
