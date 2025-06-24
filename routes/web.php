<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExcelImportController;

Route::get('/service-report/{serviceEventId}', [PDFController::class, 'generateServiceReport']);


//Route::get('/excel/import', [ExcelImportController::class, 'showForm'])->name('excel.import.form');
//Route::post('/excel/import', [ExcelImportController::class, 'import'])->name('excel.import');

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

// Dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('company')) {
        return redirect()->route('company.service-events.index');
    }

    // super_admin ili default
    return app(\App\Http\Controllers\DashboardController::class)->index();
})->middleware(['auth'])->name('dashboard');

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
    });
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/company.php';
require __DIR__ . '/attachments.php';
require __DIR__ . '/api.php';


