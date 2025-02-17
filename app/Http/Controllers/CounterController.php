<?php

namespace App\Http\Controllers;

use App\Http\Requests\CounterRequest;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        return response()->json(Counter::all());
    }

    public function store(CounterRequest $request)
    {
        $counter = Counter::create($request->validated());
        return response()->json($counter, 201);
    }

    public function show(Counter $counter)
    {
        return response()->json($counter);
    }

    public function update(CounterRequest $request, Counter $counter)
    {
        $counter->update($request->validated());
        return response()->json($counter);
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return response()->json(null, 204);
    }
}

