<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LocationController;

Route::middleware(['auth'])->group(function () {
    
    Route::get('/api/cities', [CityController::class, 'index']);
    Route::get('/api/cities/search', [CityController::class, 'search']);

    Route::get('/api/companies/{company}/locations', [LocationController::class, 'api']);
});
