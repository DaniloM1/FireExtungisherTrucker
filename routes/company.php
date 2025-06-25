<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\ServiceEventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HydrantController;

Route::middleware(['auth', 'role:company'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        // Servisni događaji
        Route::get('/service-events', [CompanyUserController::class, 'index'])
            ->name('service-events.index');
        Route::get('/service-events/{service_event}', [ServiceEventController::class, 'show'])
            ->name('service-events.show');

        // Lokacije i uređaji
        Route::get('/locations/{location}', [LocationController::class, 'show'])
            ->name('locations.show');

        Route::get('/locations/{location}/devices', [DeviceController::class, 'index'])
            ->name('locations.devices.index');

        Route::get('/locations/{location}/hydrants', [HydrantController::class, 'index'])
            ->name('locations.hydrants.index');
    });

