<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WorkingHoursRequest;
use App\Models\WorkingHours;
use App\Http\Resources\WorkingHoursCollection;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class WorkingHoursController extends Controller
{
    public function index(Request $request): WorkingHoursCollection
    {
        $workingHours = WorkingHours::where('service_provider_id', auth()->id())->get();

        return new WorkingHoursCollection($workingHours);
    }

    public function store(WorkingHoursRequest $request): WorkingHoursCollection
    {
        $serviceProvider = auth()->user();
        $validatedWorkingHours = $request->validated();

        $weekdays = collect($validatedWorkingHours)->pluck('weekday')->toArray();
        WorkingHours::where('service_provider_id', $serviceProvider->id)->whereNotIn('weekday', $weekdays)->delete();

        foreach ($validatedWorkingHours as $workingHours) {
            WorkingHours::updateOrCreate(
                [
                    'service_provider_id' => $serviceProvider->id,
                    'weekday' => $workingHours['weekday']
                ],
                [
                    'start_time' => $workingHours['start_time'],
                    'end_time' => $workingHours['end_time']
                ]
            );
        }

        return new WorkingHoursCollection($serviceProvider->workingHours);
    }

    public function fetchWorkingHours(Request $request, ServiceProvider $serviceProvider): WorkingHoursCollection | JsonResponse
    {
        $validator = Validator::make($request->query(), [
            'appointment_date' => ['required', 'date'],
            'weekday' => ['required', 'integer', 'min:0', 'max:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $appointmentDate = $request->query('appointment_date');
        $weekday = (int) $request->query('weekday');

        $workingHours = $serviceProvider->workingHours()->where('weekday', $weekday)->with(['appointments' => function ($query) use ($appointmentDate) {
            $query->whereDate('appointment_date', $appointmentDate);
        }])->get();

        return new WorkingHoursCollection($workingHours);
    }
}
