<?php
namespace App\Http\Controllers;

use App\Http\Requests\HeroAreaRequest;
use App\Models\HeroArea;
use Illuminate\Http\Request;

class HeroAreaController extends Controller
{
    public function index()
    {
        return response()->json(HeroArea::all());
    }

    public function store(HeroAreaRequest $request)
    {
        $heroArea = HeroArea::create($request->validated());
        return response()->json($heroArea, 201);
    }

    public function show(HeroArea $heroArea)
    {
        return response()->json($heroArea);
    }

    public function update(HeroAreaRequest $request, HeroArea $heroArea)
    {
        $heroArea->update($request->validated());
        return response()->json($heroArea);
    }

    public function destroy(HeroArea $heroArea)
    {
        $heroArea->delete();
        return response()->json(null, 204);
    }
}
