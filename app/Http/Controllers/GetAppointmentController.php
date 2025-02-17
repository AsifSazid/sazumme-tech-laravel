<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAppointmentRequest;
use App\Models\GetAppointment;
use Illuminate\Http\Request;

class GetAppointmentController extends Controller
{
    public function index()
    {
        return response()->json(GetAppointment::all());
    }

    public function store(GetAppointmentRequest $request)
    {
        $appointment = GetAppointment::create($request->validated());
        return response()->json($appointment, 201);
    }

    public function show(GetAppointment $appointment)
    {
        return response()->json($appointment);
    }

    public function destroy(GetAppointment $appointment)
    {
        $appointment->delete();
        return response()->json(null, 204);
    }
}
