<?php

namespace App\Http\Controllers;

use App\Http\Requests\PolicyRequest;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        return response()->json(Policy::all());
    }

    public function store(PolicyRequest $request)
    {
        $policy = Policy::create($request->validated());
        return response()->json($policy, 201);
    }

    public function show(Policy $policy)
    {
        return response()->json($policy);
    }

    public function update(PolicyRequest $request, Policy $policy)
    {
        $policy->update($request->validated());
        return response()->json($policy);
    }

    public function destroy(Policy $policy)
    {
        $policy->delete();
        return response()->json(null, 204);
    }
}
