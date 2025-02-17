<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function index()
    {
        return response()->json(Subscribe::all());
    }

    public function store(SubscribeRequest $request)
    {
        $subscription = Subscribe::create($request->validated());
        return response()->json($subscription, 201);
    }

    public function destroy(Subscribe $subscription)
    {
        $subscription->delete();
        return response()->json(null, 204);
    }
}
