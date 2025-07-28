<?php

namespace App\Http\Controllers;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(AppointmentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $isAlreadyBooked = Appointment::where('service_provider_id', $validatedData['service_provider_id'])
            ->whereDate('appointment_date', $validatedData['appointment_date'])
            ->whereTime('appointment_time', $validatedData['appointment_time'])
            ->exists();

        if ($isAlreadyBooked) {
            return response()->json(['message' => 'Šis laikas jau užimtas. Prašome pasirinkti kitą laiką'], Response::HTTP_CONFLICT);
        }

        Appointment::create($validatedData);

        return response()->json(['message' => 'Jūsų registracija buvo sėkminga!'], Response::HTTP_CREATED);
    }
}
