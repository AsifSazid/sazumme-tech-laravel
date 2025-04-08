<?php

namespace App\Http\Controllers;

use App\Http\Requests\WingRequest;
use App\Models\Wing;
use Illuminate\Http\Request;

class WingController extends Controller
{
    public function index()
    {
        return response()->json(Wing::all());
    }

    public function store(WingRequest $request)
    {
        $wing = Wing::create($request->validated());
        return response()->json($wing, 201);
    }

    public function show(Wing $wing)
    {
        return response()->json($wing);
    }

    public function update(WingRequest $request, Wing $wing)
    {
        $wing->update($request->validated());
        return response()->json($wing);
    }

    public function destroy(Wing $wing)
    {
        $wing->delete();
        return response()->json(null, 204);
    }
}

