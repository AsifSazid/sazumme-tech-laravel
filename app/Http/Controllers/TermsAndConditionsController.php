<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermsAndConditionsRequest;
use App\Models\TermsAndConditions;
use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    public function index()
    {
        return response()->json(TermsAndConditions::all());
    }

    public function store(TermsAndConditionsRequest $request)
    {
        $terms = TermsAndConditions::create($request->validated());
        return response()->json($terms, 201);
    }

    public function show(TermsAndConditions $terms)
    {
        return response()->json($terms);
    }

    public function update(TermsAndConditionsRequest $request, TermsAndConditions $terms)
    {
        $terms->update($request->validated());
        return response()->json($terms);
    }

    public function destroy(TermsAndConditions $terms)
    {
        $terms->delete();
        return response()->json(null, 204);
    }
}
