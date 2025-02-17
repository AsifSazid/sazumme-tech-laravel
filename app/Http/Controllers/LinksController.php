<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinksRequest;
use App\Models\Links;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index()
    {
        return response()->json(Links::all());
    }

    public function store(LinksRequest $request)
    {
        $link = Links::create($request->validated());
        return response()->json($link, 201);
    }

    public function show(Links $link)
    {
        return response()->json($link);
    }

    public function update(LinksRequest $request, Links $link)
    {
        $link->update($request->validated());
        return response()->json($link);
    }

    public function destroy(Links $link)
    {
        $link->delete();
        return response()->json(null, 204);
    }
}
