<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutCompanyRequest;
use App\Models\AboutCompany;
use Illuminate\Http\Request;

class AboutCompanyController extends Controller
{
    public function index()
    {
        return response()->json(AboutCompany::all());
    }

    public function store(AboutCompanyRequest $request)
    {
        $about = AboutCompany::create($request->validated());
        return response()->json($about, 201);
    }

    public function show(AboutCompany $about)
    {
        return response()->json($about);
    }

    public function update(AboutCompanyRequest $request, AboutCompany $about)
    {
        $about->update($request->validated());
        return response()->json($about);
    }

    public function destroy(AboutCompany $about)
    {
        $about->delete();
        return response()->json(null, 204);
    }
}
