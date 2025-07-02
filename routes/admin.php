<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ServiceEventController;
use App\Http\Controllers\LocationGroupController;
use App\Http\Controllers\HydrantController;
use App\Http\Controllers\PostController;

/*
  |--------------------------------------------------------------------------
  | Super Admin Routes
  |--------------------------------------------------------------------------
*/


Route::prefix('admin')->middleware('role:super_admin')->group(function () {
    // User Management
    Route::resource('users', UserManagementController::class);

    // Service Events
    Route::resource('service-events', ServiceEventController::class);
    Route::get('service-events/test/{group}', [ServiceEventController::class, 'groupService'])->name('service-events.group-service');
    // web.php
    Route::post('/service-events/{serviceEvent}/locations/{location}/complete', [ServiceEventController::class, 'markDone'])
        ->name('service-events.locations.complete');

    // Location Groups
    Route::resource('location-groups', LocationGroupController::class);



    // Companies
    Route::resource('companies', CompanyController::class);

    // Company Locations
    Route::prefix('companies/{company}')->group(function () {
        Route::get('/locations', [LocationController::class, 'index'])->name('companies.locations.index');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('companies.locations.create');
        Route::post('/locations', [LocationController::class, 'store'])->name('companies.locations.store');
    });

    // Locations
    Route::controller(LocationController::class)->prefix('locations')->group(function () {
        Route::get('/{location}', 'show')->name('locations.show');
        Route::get('/', 'test')->name('locations.test');
        Route::get('/{location}/edit', 'edit')->name('locations.edit');
        Route::put('/{location}', 'update')->name('locations.update');
        Route::delete('/{location}', 'destroy')->name('locations.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Device & Group Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('locations/{location}')->group(function () {
        // Locations Devices
        Route::prefix('devices')->controller(DeviceController::class)->group(function () {
            Route::get('/', 'index')->name('locations.devices.index');

            Route::get('/create', 'create')->name('locations.devices.create');
            Route::post('/', 'store')->name('locations.devices.store');
        });

        // Groups
        Route::prefix('groups')->controller(GroupController::class)->group(function () {
            Route::get('/', 'index')->name('locations.groups.index');
            Route::get('/create', 'create')->name('locations.groups.create');
            Route::post('/', 'store')->name('locations.groups.store');
        });

        Route::prefix('hydrants')->controller(HydrantController::class)->group(function () {
            Route::get('/', 'index')->name('locations.hydrants.index');
            Route::get('/create', 'create')->name('locations.hydrants.create');
            Route::post('/', 'store')->name('locations.hydrants.store');
            Route::get('/{hydrant}/edit','edit')->name('locations.hydrants.edit');
            Route::patch('/{hydrant}',   'update')->name('locations.hydrants.update');
            Route::delete('/{hydrant}',  'destroy')->name('locations.hydrants.destroy');
        });
    });


    // Devices
    Route::controller(DeviceController::class)->prefix('devices')->group(function () {
        Route::patch('/{device}/update-status', 'updateStatus')->name('devices.updateStatus');
        Route::get('/{device}/edit', 'edit')->name('devices.edit');
        Route::put('/{device}', 'update')->name('devices.update');
        Route::delete('/{device}', 'destroy')->name('devices.destroy');
    });

    // Groups
    Route::controller(GroupController::class)->prefix('groups')->group(function () {
        Route::get('/{group}', 'show')->name('groups.show');
        Route::get('/{group}/edit', 'edit')->name('groups.edit');
        Route::put('/{group}', 'update')->name('groups.update');
        Route::delete('/{group}', 'destroy')->name('groups.destroy');
        Route::get('/{group}/add-device', 'addDevice')->name('groups.add-device');
        Route::post('/{group}/add-device', 'storeDevice')->name('groups.store-device');
    });
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'index')->name('posts.index');
        Route::get('/create', 'create')->name('posts.create');
        Route::post('/', 'store')->name('posts.store');
        Route::get('/{post}', 'show')->name('posts.show');
        Route::get('/{post}/edit', 'edit')->name('posts.edit');
        Route::patch('/{post}', 'update')->name('posts.update');
        Route::delete('/{post}', 'destroy')->name('posts.destroy');
    });

    // API Routes
});

