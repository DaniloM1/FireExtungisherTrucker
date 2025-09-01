<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Exam\PrivateDocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AttachmentController;




/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


Route::get('/attachments/view/{attachment}', [AttachmentController::class, 'view'])
    ->name('attachments.view')
    ->middleware('auth');

Route::middleware('auth')->get('/private-documents/{filename}', [PrivateDocumentController::class, 'show'])->name('private.documents.show');

Route::post('/kontakt', [ContactController::class, 'sendMessage'])->name('contact.send');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::controller(FrontController::class)->group(function () {
    // Glavna
    Route::get('/', 'index')->name('home');
    Route::get('/o-nama', 'aboutUs')->name('aboutUs');
    Route::get('/kontakt', 'contact')->name('contact');

    // Usluge
    Route::get('/usluge', 'services')->name('services');
    Route::prefix('usluge')->name('services.')->group(function () {
        Route::get('/inspekcija-aparata', 'inspection')->name('inspection');
        Route::get('/protivpozarni-sistemi', 'protection')->name('protection');
        Route::get('/evakuacijski-planovi', 'evacuation')->name('evacuation');
        Route::get('/ugradnja-servis', 'installation')->name('installation');
        Route::get('/polaganje-strucnog-ispita', 'exam')->name('exam');
        Route::get('/obuke-edukacija', 'training')->name('training');
    });
});

// Dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('company')) {
        return redirect()->route('company.service-events.index');
    }
    if ($user->hasRole('student')) {
        return redirect()->route('exam.index');
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
    Route::resource('location_checks', \App\Http\Controllers\LocationCheckController::class);
    Route::get('/service-report/{serviceEventId}', [PDFController::class, 'generateServiceReport'])->name('service-report.generate');

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
require __DIR__ . '/exam.php';
require __DIR__ . '/api.php';


