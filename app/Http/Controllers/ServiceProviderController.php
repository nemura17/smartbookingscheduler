<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ServiceProviderCollection;
use App\Models\ServiceProvider;

class ServiceProviderController extends Controller
{
    public function index(): ServiceProviderCollection
    {
        $serviceProviders = ServiceProvider::all();

        return new ServiceProviderCollection($serviceProviders);
    }
}
