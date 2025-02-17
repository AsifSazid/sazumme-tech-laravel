<?php

namespace App\Http\Controllers;

use App\Http\Requests\OurExpertiseRequest;
use App\Models\OurExpertise;
use Illuminate\Http\Request;

class OurExpertiseController extends Controller
{
    public function index()
    {
        return response()->json(OurExpertise::all());
    }

    public function store(OurExpertiseRequest $request)
    {
        $expertise = OurExpertise::create($request->validated());
        return response()->json($expertise, 201);
    }

    public function show(OurExpertise $expertise)
    {
        return response()->json($expertise);
    }

    public function update(OurExpertiseRequest $request, OurExpertise $expertise)
    {
        $expertise->update($request->validated());
        return response()->json($expertise);
    }

    public function destroy(OurExpertise $expertise)
    {
        $expertise->delete();
        return response()->json(null, 204);
    }
}

