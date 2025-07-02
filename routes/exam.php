<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Exam\ExamGroupController;
use App\Http\Controllers\Exam\ExamSubjectController;
use App\Http\Controllers\Exam\ExamGroupMemberController;
use App\Http\Controllers\Exam\ExamMemberSubjectController;
use App\Http\Controllers\Exam\ExamController;

// Sve admin/super-admin rute u jednu grupu:
Route::middleware(['role:super_admin'])->group(function () {
    Route::resource('exam-groups', ExamGroupController::class);
    Route::post('/exam-groups/{examGroup}/subjects/{subject}/unlock', [ExamGroupController::class, 'unlockSubject'])
        ->name('exam-groups.subjects.unlock');
    Route::get('/exam-groups/{examGroup}/subjects/{subject}/materials', [ExamGroupController::class, 'materials'])
        ->name('exam-groups.materials');
    Route::get('/exam-groups/user-search', [ExamGroupController::class, 'globalUserSearch'])
        ->name('exam.groups.global-user-search');
    Route::get('/exam-groups/{group}/not-in-group', [ExamGroupController::class, 'usersNotInGroup'])->name('exam.groups.not-in-group');
    Route::post('/exam-groups/{group}/add-member', [ExamGroupController::class, 'addMember'])->name('exam.groups.add-member');
    Route::get('/exam-groups/{group}/user-search', [ExamGroupController::class, 'userSearch'])->name('exam.groups.user-search');

    // Dodaj i ove ako treba (za admin only):
    Route::resource('exam-subjects', ExamSubjectController::class);
    Route::resource('exam-group-members', ExamGroupMemberController::class);
    Route::resource('exam-member-subjects', ExamMemberSubjectController::class);
    Route::resource('documents', \App\Http\Controllers\Exam\DocumentController::class);
    Route::resource('announcements', \App\Http\Controllers\Exam\AnnouncementController::class);
});

// Student vidi samo svoje grupe (ne može dodavanje, izmenu, brisanje, samo pregled):
Route::middleware(['role:student|super_admin'])->group(function () {
    Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
    Route::get('student/exam-groups/{examGroup}', [ExamGroupController::class, 'show'])->name('student.exam-groups.show');
    Route::get('/exam-groups/{examGroup}/subjects/{subject}/materials', [ExamGroupController::class, 'materials'])
        ->name('exam-groups.materials');
});

