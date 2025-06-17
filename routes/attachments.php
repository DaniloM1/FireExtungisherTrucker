<?php

use Illuminate\Support\Facades\Route;

Route::post('/attachments', [\App\Http\Controllers\AttachmentController::class, 'store'])->name('attachments.store');
Route::delete('/attachments/{attachment}', [\App\Http\Controllers\AttachmentController::class, 'destroy'])->name('attachments.destroy');
Route::post('/attachments/{id}/restore', [\App\Http\Controllers\AttachmentController::class, 'restore'])->name('attachments.restore');
Route::delete('/attachments/{id}/force', [\App\Http\Controllers\AttachmentController::class, 'forceDelete'])->name('attachments.forceDelete');
Route::post('/locations/{location}/attachments', [\App\Http\Controllers\AttachmentController::class, 'storeForLocation'])
    ->name('locations.attachments.store');
// Pretpostavljam da koristiš resourceful stil i CompanyUserController ili poseban ServiceEventAttachmentController
Route::post('/service-events/{serviceEvent}/attachments', [\App\Http\Controllers\AttachmentController::class, 'storeForServiceEvent'])
    ->name('service-events.attachments.store');


