<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAQuoteRequest;
use App\Models\RequestAQuote;
use Illuminate\Http\Request;

class RequestAQuoteController extends Controller
{
    public function index()
    {
        return response()->json(RequestAQuote::all());
    }

    public function store(RequestAQuoteRequest $request)
    {
        $quote = RequestAQuote::create($request->validated());
        return response()->json($quote, 201);
    }

    public function show(RequestAQuote $quote)
    {
        return response()->json($quote);
    }

    public function destroy(RequestAQuote $quote)
    {
        $quote->delete();
        return response()->json(null, 204);
    }
}
