<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;

Route::middleware(['auth'])->group(function () {
    Route::post('/attachments', [AttachmentController::class, 'store'])
        ->name('attachments.store');

    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');

    Route::post('/attachments/{id}/restore', [AttachmentController::class, 'restore'])
        ->name('attachments.restore');

    Route::delete('/attachments/{id}/force', [AttachmentController::class, 'forceDelete'])
        ->name('attachments.forceDelete');

    Route::post('/locations/{location}/attachments', [AttachmentController::class, 'storeForLocation'])
        ->name('locations.attachments.store');

    Route::post('/service-events/{serviceEvent}/attachments', [AttachmentController::class, 'storeForServiceEvent'])
        ->name('service-events.attachments.store');

    Route::post('/service-events/{serviceEvent}/locations/{location}/attachments', [AttachmentController::class, 'storeForServiceEventLocation'])
        ->name('service-events.locations.attachments.store');
});
