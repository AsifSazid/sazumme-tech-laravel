<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInfoRequest;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        return response()->json(ContactInfo::all());
    }

    public function store(ContactInfoRequest $request)
    {
        $contact = ContactInfo::create($request->validated());
        return response()->json($contact, 201);
    }

    public function show(ContactInfo $contact)
    {
        return response()->json($contact);
    }

    public function update(ContactInfoRequest $request, ContactInfo $contact)
    {
        $contact->update($request->validated());
        return response()->json($contact);
    }

    public function destroy(ContactInfo $contact)
    {
        $contact->delete();
        return response()->json(null, 204);
    }
}

