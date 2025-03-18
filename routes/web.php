<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceEventController;
use App\Http\Controllers\LocationGroupController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/usluge', 'services')->name('services');

    // Pojedinačne usluge
    Route::get('/usluge/inspekcija-aparata', 'inspection')->name('services.inspection');
    Route::get('/usluge/protivpozarni-sistemi', 'protection')->name('services.protection');
    Route::get('/usluge/evakuacijski-planovi', 'evacuation')->name('services.evacuation');
    Route::get('/usluge/ugradnja-servis', 'installation')->name('services.installation');
    Route::get('/usluge/polaganje-ispita', 'exam')->name('services.exam');
    Route::get('/usluge/obuke-edukacija', 'training')->name('services.training');

    Route::get('/o-nama', 'aboutUs')->name('aboutUs');
    Route::get('/kontakt', 'contact')->name('contact');
});


Route::get('/api/cities', [CityController::class, 'index']);
Route::get('/api/cities/search', [CityController::class, 'search']);
// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    //Blog admin controll
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'index')->name('posts.index');
        Route::get('/create', 'create')->name('posts.create');
        Route::post('/', 'store')->name('posts.store');
        Route::get('/{post}', 'show')->name('posts.show');
        Route::get('/{post}/edit', 'edit')->name('posts.edit');
        Route::patch('/{post}', 'update')->name('posts.update');
        Route::delete('/{post}', 'destroy')->name('posts.destroy');
    });

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // User Management
    Route::resource('users', UserManagementController::class);

    // Service Events
    Route::resource('service-events', ServiceEventController::class);

    // Location Groups
    Route::resource('location-groups', LocationGroupController::class);

    /*
    |--------------------------------------------------------------------------
    | Super Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin')->group(function () {
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
            Route::get('/', 'test')->name('locations.test');
            Route::get('/{location}/edit', 'edit')->name('locations.edit');
            Route::put('/{location}', 'update')->name('locations.update');
            Route::delete('/{location}', 'destroy')->name('locations.destroy');
        });
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

    // API Routes
    Route::get('api/companies/{company}/locations', [LocationController::class, 'api']);
});

require __DIR__ . '/auth.php';
