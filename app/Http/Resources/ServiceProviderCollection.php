<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ServiceProviderResource;

class ServiceProviderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'service_providers' => $this->collection->map(function ($serviceProvider): ServiceProviderResource {
                return new ServiceProviderResource($serviceProvider);
            })
        ];
    }
}
