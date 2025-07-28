<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ServiceCollection;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(): ServiceCollection
    {
        $services = Service::all();

        return new ServiceCollection($services);
    }
}
