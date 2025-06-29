<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Exam\ExamGroupController;
use App\Http\Controllers\Exam\ExamSubjectController;
use App\Http\Controllers\Exam\ExamGroupMemberController;
use App\Http\Controllers\Exam\ExamMemberSubjectController;
use App\Http\Controllers\Exam\ExamController;


Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
Route::resource('exam-groups', ExamGroupController::class);
Route::post('/exam-groups/{examGroup}/subjects/{subject}/unlock', [ExamGroupController::class, 'unlockSubject'])
    ->name('exam-groups.subjects.unlock');

Route::get('/exam-groups/{examGroup}/subjects/{subject}/materials', [ExamGroupController::class, 'materials'])
    ->name('exam-groups.materials');


Route::resource('exam-subjects', ExamSubjectController::class);
Route::resource('exam-group-members', ExamGroupMemberController::class);
Route::resource('exam-member-subjects', ExamMemberSubjectController::class);
Route::resource('documents', \App\Http\Controllers\Exam\DocumentController::class);
Route::resource('announcements', \App\Http\Controllers\Exam\AnnouncementController::class);

