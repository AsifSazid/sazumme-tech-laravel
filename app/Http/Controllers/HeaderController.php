<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeaderRequest;
use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function index()
    {
        return response()->json(Header::all());
    }

    public function store(HeaderRequest $request)
    {
        $header = Header::create($request->validated());
        return response()->json($header, 201);
    }

    public function show(Header $header)
    {
        return response()->json($header);
    }

    public function update(HeaderRequest $request, Header $header)
    {
        $header->update($request->validated());
        return response()->json($header);
    }

    public function destroy(Header $header)
    {
        $header->delete();
        return response()->json(null, 204);
    }
}
