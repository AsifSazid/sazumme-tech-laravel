<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReasonsToChooseUsRequest;
use App\Models\ReasonsToChooseUs;

class ReasonsToChooseUsController extends Controller
{
    public function index()
    {
        return response()->json(ReasonsToChooseUs::all());
    }

    public function store(ReasonsToChooseUsRequest $request)
    {
        $reason = ReasonsToChooseUs::create($request->validated());
        return response()->json($reason, 201);
    }

    public function show(ReasonsToChooseUs $reason)
    {
        return response()->json($reason);
    }

    public function update(ReasonsToChooseUsRequest $request, ReasonsToChooseUs $reason)
    {
        $reason->update($request->validated());
        return response()->json($reason);
    }

    public function destroy(ReasonsToChooseUs $reason)
    {
        $reason->delete();
        return response()->json(null, 204);
    }
}
