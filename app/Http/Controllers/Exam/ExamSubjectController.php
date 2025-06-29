<?php

namespace App\Http\Controllers\Exam;


use App\Models\Exam\ExamSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ExamSubjectController extends Controller
{
    public function index()
    {
        $subjects = ExamSubject::orderBy('name')->paginate(50);
        return view('exam_subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('exam_subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'education_level' => 'required|in:ALL,SSS,VSS',
            'description'     => 'nullable|string',
        ]);
        ExamSubject::create($validated);

        return redirect()->route('exam_subjects.index')->with('success', 'Predmet dodat.');
    }

    public function edit(ExamSubject $examSubject)
    {
        return view('exam_subjects.edit', compact('examSubject'));
    }

    public function update(Request $request, ExamSubject $examSubject)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'education_level' => 'required|in:ALL,SSS,VSS',
            'description'     => 'nullable|string',
        ]);
        $examSubject->update($validated);

        return redirect()->route('exam_subjects.index')->with('success', 'Predmet izmenjen.');
    }

    public function destroy(ExamSubject $examSubject)
    {
        $examSubject->delete();
        return redirect()->route('exam_subjects.index')->with('success', 'Predmet obrisan.');
    }
}
