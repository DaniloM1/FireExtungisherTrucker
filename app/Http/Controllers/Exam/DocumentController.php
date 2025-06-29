<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\Document;
use App\Models\Exam\DocumentType;
use App\Models\Exam\ExamSubject;
use App\Models\Exam\ExamGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
class DocumentController extends Controller
{
    public function index(Request $request)
    {
        // Filtracija po tipu ili entitetu
        $documents = Document::with('documentType')
            ->when($request->input('exam_subject_id'), fn($q, $v) => $q->where('exam_subject_id', $v))
            ->when($request->input('exam_group_id'), fn($q, $v) => $q->where('exam_group_id', $v))
            ->paginate(50);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $types = DocumentType::all();
        $subjects = ExamSubject::all();
        $groups = ExamGroup::all();
        return view('documents.create', compact('types', 'subjects', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'file'             => 'required|file|max:20480', // max 20MB
            'name'             => 'nullable|string|max:255',
            'description'      => 'nullable|string|max:500',
            'exam_subject_id'  => 'nullable|exists:exam_subjects,id',
            'exam_group_id'    => 'nullable|exists:exam_groups,id',
            'user_id'          => 'nullable|exists:users,id',
        ]);

        // **1. Čuvamo fajl na 'public' disku**, tako da bude dostupan putem /storage/…
        $publicPath = $request->file('file')
            ->store('documents', 'public');

        // 2. Ubacimo putanju i uploader ID u array
        $validated['file_path']   = $publicPath;
        $validated['uploaded_by'] = Auth::id();

        // 3. Kreiramo zapis
        Document::create($validated);

        return back()->with('success', 'Dokument uspešno dodat.');
    }


    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Dokument obrisan.');
    }
}

