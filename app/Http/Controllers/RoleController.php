<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(10);
        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            // 'is_active' => 'nullable|boolean',
        ]);

        try {
            $role = Role::create([
                'uuid' => (string) \Str::uuid(),
                'name' => $request->title,
                'alias' => $request->alias,
                'created_by' => Auth::user()->name,
                // 'created_by_uuid' => Auth::user()->uuid,
                // 'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('roles.index')->with('success', 'Role created successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($role)
    {
        $role = Role::where('uuid', $role)->first();
        return view('backend.roles.show', compact('role'));
    }

    public function edit($role)
    {
        $role = Role::where('uuid', $role)->first();
        return view('backend.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request['is_active'] = $request->has('is_active') ? 1 : 0;

        $request->validate([
            'title' => 'required|string',
            // 'is_active' => 'nullable|boolean',
        ]);

        try {
            $role->update([
                'uuid' => (string) \Str::uuid(),
                'name' => $request->title,
                'alias' => $request->alias,
                'created_by' => Auth::user()->name,
                // 'created_by_uuid' => Auth::user()->uuid,
                // 'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($uuid)
    {
        $role = Role::where('uuid', $uuid);
        $role->delete(); // this is soft delete

        return redirect()->route('roles.index')->with('success', 'Role moved to trash.');
    }

    public function trash()
    {
        $trashedCollection = Role::onlyTrashed()->latest();
        $trashed = $trashedCollection->paginate(10);
        return view('backend.roles.trash', compact('trashed'));
    }

    public function restore($uuid)
    {
        $role = Role::onlyTrashed()->where('uuid', $uuid);
        $role->restore();

        return redirect()->route('roles.trash')->with('success', 'Role restored successfully.');
    }

    public function forceDelete($uuid)
    {
        $role = Role::onlyTrashed()->where('uuid', $uuid);
        $role->forceDelete();

        return redirect()->route('roles.trash')->with('success', 'Role permanently deleted.');
    }

    public function getData(Request $request)
    {
        $query = Role::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $roles = $query->orderBy('created_at', 'asc')->paginate(10);

        return response()->json($roles);

        // return response()->json([
        //     'data' => $roles->items(),
        //     'current_page' => $roles->currentPage(),
        //     'last_page' => $roles->lastPage(),
        //     'per_page' => $roles->perPage(),
        //     'total' => $roles->total(),
        // ]);
    }
}
