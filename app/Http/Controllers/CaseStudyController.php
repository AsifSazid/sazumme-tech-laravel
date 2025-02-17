<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseStudyRequest;
use App\Models\CaseStudy;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index()
    {
        return response()->json(CaseStudy::all());
    }

    public function store(CaseStudyRequest $request)
    {
        $caseStudy = CaseStudy::create($request->validated());
        return response()->json($caseStudy, 201);
    }

    public function show(CaseStudy $caseStudy)
    {
        return response()->json($caseStudy);
    }

    public function update(CaseStudyRequest $request, CaseStudy $caseStudy)
    {
        $caseStudy->update($request->validated());
        return response()->json($caseStudy);
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $caseStudy->delete();
        return response()->json(null, 204);
    }
}

