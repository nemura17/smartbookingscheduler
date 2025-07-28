<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WorkingHoursController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () { return Inertia::render('Welcome'); })->name('home');

Route::controller(ServiceController::class)->group(function () {
    Route::get('services', 'index')->name('services.index');
});

Route::controller(ServiceProviderController::class)->group(function () {
    Route::get('service_providers', 'index')->name('service_providers.index');
});

Route::controller(AppointmentController::class)->group(function () {
    Route::post('appointments', 'store')->name('appointments.store');
});

Route::controller(WorkingHoursController::class)->group(function () {
    Route::get('working_hours/{serviceProvider}', 'fetchWorkingHours')->name('working_hours.fetchWorkingHours');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');

    Route::controller(WorkingHoursController::class)->group(function () {
        Route::get('working_hours', 'index')->name('working_hours.index');
        Route::post('working_hours', 'store')->name('working_hours.store');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
