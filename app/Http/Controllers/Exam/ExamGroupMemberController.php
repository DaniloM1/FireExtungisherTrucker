<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\ExamGroup;
use App\Models\Exam\ExamGroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ExamGroupMemberController extends Controller
{
    public function store(Request $request, ExamGroup $examGroup)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        ExamGroupMember::create([
            'exam_group_id' => $examGroup->id,
            'user_id'       => $validated['user_id'],
            'status'        => 'active',
            'joined_at'     => now(),
        ]);

        return back()->with('success', 'Korisnik dodat u grupu.');
    }

    public function destroy(ExamGroupMember $examGroupMember)
    {
        $examGroupMember->delete();
        return back()->with('success', 'Korisnik izbačen iz grupe.');
    }
}

