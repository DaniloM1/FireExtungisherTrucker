<?php
//
//use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\CompanyController;
//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserManagementController;
//use App\Http\Controllers\LocationController;
//use App\Http\Controllers\DeviceController;
//use  App\Http\Controllers\GroupController;
//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//Route::resource('users', \App\Http\Controllers\UserManagementController::class);
//Route::middleware(['auth', 'role:super_admin'])->group(function () {
//    // Rute za kompanije
//    Route::resource('companies', CompanyController::class);
//
//    // Rute za lokacije unutar kompanije
//    Route::get('companies/{company}/locations', [LocationController::class, 'index'])->name('companies.locations');
//    Route::get('companies/{company}/locations/create', [LocationController::class, 'create'])->name('locations.create');
//    Route::post('companies/{company}/locations', [LocationController::class, 'store'])->name('locations.store');
//
//
//    // Rute za uređivanje, ažuriranje i brisanje lokacija (neugneštene rute)
//    Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
//    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
//    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
//
//});
//
//
//Route::get('locations/{location}/groups', [GroupController::class, 'index'])->name('locations.groups.index');
////Route::get('locations/{location}/groups/create', [GroupController::class, 'create'])->name('locations.groups.create');
////Route::post('locations/{location}/groups', [GroupController::class, 'store'])->name('locations.groups.store');
//
//Route::get('groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
//Route::put('groups/{group}', [GroupController::class, 'update'])->name('groups.update');
//Route::delete('groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
//
//// Uređaji
//Route::get('locations/{location}/devices', [DeviceController::class, 'index'])->name('locations.devices.index');
//Route::get('locations/{location}/devices/create', [DeviceController::class, 'create'])->name('locations.devices.create');
//Route::post('locations/{location}/devices', [DeviceController::class, 'store'])->name('locations.devices.store');
//
//Route::get('devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
//Route::put('devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
//Route::delete('devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
//
//
//
//Route::get('locations/{location}/groups', [GroupController::class, 'index'])->name('locationsx.groups.index');
//Route::get('locations/{location}/groups/create', [GroupController::class, 'create'])->name('locations.groups.create');
//Route::post('locations/{location}/groups', [GroupController::class, 'store'])->name('locations.groups.store');
//
//// Rute za operacije na pojedinoj grupi (prikaz, uređivanje, ažuriranje, brisanje)
//Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show');
//Route::get('groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
//Route::put('groups/{group}', [GroupController::class, 'update'])->name('groups.update');
//Route::delete('groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
//Route::get('groups/{group}/add-device', [GroupController::class, 'addDevice'])->name('groups.add-device');
//Route::post('groups/{group}/add-device', [GroupController::class, 'storeDevice'])->name('groups.store-device');
//
//require __DIR__.'/auth.php';


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\GroupController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Ova ruta zahteva autentifikaciju i verifikaciju korisnika.
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
| Rute za upravljanje profilom (samo za prijavljenog korisnika)
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
| Rute za upravljanje korisnicima (koriste se u okviru auth middleware-a)
*/
Route::resource('users', UserManagementController::class)->middleware('auth');

/*
|--------------------------------------------------------------------------
| Company & Location Routes
|--------------------------------------------------------------------------
| Ove rute su dostupne samo korisnicima sa ulogom "super_admin"
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // Kompanije
    Route::resource('companies', CompanyController::class);

    // Lokacije unutar kompanije
    Route::get('companies/{company}/locations', [LocationController::class, 'index'])->name('companies.locations');
    Route::get('companies/{company}/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('companies/{company}/locations', [LocationController::class, 'store'])->name('locations.store');

    // Uređivanje i brisanje lokacija
    Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

});

/*
|--------------------------------------------------------------------------
| Group Routes
|--------------------------------------------------------------------------
| Rute za grupe, uključujući prikaz, kreiranje i uređivanje.
| Dostupne su korisnicima koji su prijavljeni.
*/
Route::middleware('auth')->group(function () {
    // Grupe unutar određene lokacije
    Route::get('locations/{location}/groups', [GroupController::class, 'index'])->name('locations.groups.index');
    Route::get('locations/{location}/groups/create', [GroupController::class, 'create'])->name('locations.groups.create');
    Route::post('locations/{location}/groups', [GroupController::class, 'store'])->name('locations.groups.store');
    Route::get('locations/{location}/groups', [GroupController::class, 'index'])->name('locationsx.groups.index');
    // Detalji grupe i operacije nad grupom
    Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

    // Dodavanje uređaja u grupu
    Route::get('groups/{group}/add-device', [GroupController::class, 'addDevice'])->name('groups.add-device');
    Route::post('groups/{group}/add-device', [GroupController::class, 'storeDevice'])->name('groups.store-device');
});

/*
|--------------------------------------------------------------------------
| Device Routes
|--------------------------------------------------------------------------
| Rute za uređaje unutar lokacije i operacije nad pojedinačnim uređajima.
| Dostupne su korisnicima koji su prijavljeni.
*/
Route::middleware('auth')->group(function () {
    // Uređaji unutar određene lokacije
    Route::get('locations/{location}/devices', [DeviceController::class, 'index'])->name('locations.devices.index');
    Route::get('locations/{location}/devices/create', [DeviceController::class, 'create'])->name('locations.devices.create');
    Route::post('locations/{location}/devices', [DeviceController::class, 'store'])->name('locations.devices.store');

    // Uređivanje i brisanje pojedinačnog uređaja
    Route::get('devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
    Route::put('devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
    Route::delete('devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
});

require __DIR__ . '/auth.php';
