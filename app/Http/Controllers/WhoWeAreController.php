<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhoWeAreRequest;
use App\Models\WhoWeAre;
use Illuminate\Http\Request;

class WhoWeAreController extends Controller
{
    public function index()
    {
        return response()->json(WhoWeAre::all());
    }

    public function store(WhoWeAreRequest $request)
    {
        $whoWeAre = WhoWeAre::create($request->validated());
        return response()->json($whoWeAre, 201);
    }

    public function show(WhoWeAre $whoWeAre)
    {
        return response()->json($whoWeAre);
    }

    public function update(WhoWeAreRequest $request, WhoWeAre $whoWeAre)
    {
        $whoWeAre->update($request->validated());
        return response()->json($whoWeAre);
    }

    public function destroy(WhoWeAre $whoWeAre)
    {
        $whoWeAre->delete();
        return response()->json(null, 204);
    }
}

