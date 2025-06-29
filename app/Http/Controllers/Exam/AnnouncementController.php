<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\Announcement;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\ExamSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['group', 'subject', 'user'])
            ->latest()
            ->paginate(20);

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $groups = ExamGroup::all();
        $subjects = ExamSubject::all();
        return view('announcements.create', compact('groups', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'exam_group_id' => 'required|exists:exam_groups,id',
            'exam_subject_id' => 'nullable|exists:exam_subjects,id', // dodato
        ]);

        $announcement = \App\Models\Exam\Announcement::create([
            'title' => $request->title,
            'body' => $request->body,
            'exam_group_id' => $request->exam_group_id,
            'exam_subject_id' => $request->exam_subject_id, // dodato
            'created_by' => auth()->id(),
        ]);

        // Ako je čekirano, šalji mail
//    if ($request->has('send_email')) {
//        $group = \App\Models\ExamGroup::with('members.user')->find($request->exam_group_id);
//        foreach ($group->members as $member) {
//            \Mail::to($member->user->email)
//                ->queue(new \App\Mail\Exam\GroupAnnouncementMail($announcement, $member->user));
//        }
//    }

        return back()->with('success', 'Obaveštenje kreirano' . ($request->has('send_email') ? ' i poslato na mejl.' : '.'));
    }


    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Obaveštenje obrisano.');
    }
}

