<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkingHoursCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'working_hours' => $this->collection->map(function ($workingHour): WorkingHoursResource {
                return new WorkingHoursResource($workingHour);
            })
        ];
    }
}
