<?php

namespace App\Http\Controllers;

use App\Http\Requests\FooterRequest;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        return response()->json(Footer::all());
    }

    public function store(FooterRequest $request)
    {
        $footer = Footer::create($request->validated());
        return response()->json($footer, 201);
    }

    public function show(Footer $footer)
    {
        return response()->json($footer);
    }

    public function update(FooterRequest $request, Footer $footer)
    {
        $footer->update($request->validated());
        return response()->json($footer);
    }

    public function destroy(Footer $footer)
    {
        $footer->delete();
        return response()->json(null, 204);
    }
}
