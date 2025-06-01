<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $userCollection = User::with('roles')->latest();
        $users = $userCollection->paginate(10);
        return view('backend.users.index', compact('users'));
    }

    public function assignRoles($user)
    {
        $user = User::where('uuid', $user)->first();
        $roles = Role::all();
        return view('backend.users.assign-role', compact('user', 'roles'));
    }

    public function storeAssignedRoles(Request $request, $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);
    
        // Sync roles
        $user = User::where('uuid', $user)->first();
        $user->roles()->sync($request->roles);
    
        return redirect()->route('users.index')->with('success', 'Roles assigned successfully.');
    }
}
