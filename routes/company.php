<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyUserController;
/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:company'])->prefix('company')->group(function () {

    Route::get('/service-events', [CompanyUserController::class, 'index'])
        ->name('company.service-events.index');

    Route::get('/service-events/{service_event}', [\App\Http\Controllers\ServiceEventController::class, 'show'])
        ->name('company.service-events.show');

    Route::get('/locations/{location}', [\App\Http\Controllers\LocationController::class, 'show'])
        ->name('company.locations.show');
    Route::get('/locations/{location}/devices', [\App\Http\Controllers\DeviceController::class, 'index'])
        ->name('company.locations.devices.index');
    Route::get('/locations/{location}/hydrants', [\App\Http\Controllers\HydrantController::class, 'index'])
        ->name('company.hydrant.devices.index');

});

