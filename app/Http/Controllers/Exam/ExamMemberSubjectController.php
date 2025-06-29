<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\ExamMemberSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ExamMemberSubjectController extends Controller
{
    public function update(Request $request, ExamMemberSubject $examMemberSubject)
    {
        $validated = $request->validate([
            'status'      => 'required|in:locked,unlocked,passed,failed',
            'unlocked_at' => 'nullable|date',
            'result_date' => 'nullable|date',
        ]);
        $examMemberSubject->update($validated);

        return back()->with('success', 'Status predmeta izmenjen.');
    }
}

