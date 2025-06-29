<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\ExamSubject;
use App\Models\Exam\Document;
use App\Models\Exam\Announcement;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'groups');

        $groups = ExamGroup::orderBy('start_date', 'desc')->get();
        $subjects = ExamSubject::orderBy('name')->get();
        $documents = Document::with('documentType')->latest()->get();
        $announcements = Announcement::latest()->get();

        return view('admin.exam.index', compact('tab', 'groups', 'subjects', 'documents', 'announcements'));
    }
}
