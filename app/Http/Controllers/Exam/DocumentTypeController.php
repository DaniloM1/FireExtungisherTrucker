<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class DocumentTypeController extends Controller
{
    public function index()
    {
        $types = DocumentType::orderBy('name')->paginate(20);
        return view('document_types.index', compact('types'));
    }

    public function create()
    {
        return view('document_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:document_types,code',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        DocumentType::create($validated);

        return redirect()->route('document-types.index')->with('success', 'Tip dokumenta je dodat.');
    }

    public function show(DocumentType $documentType)
    {
        return view('document_types.show', compact('documentType'));
    }

    public function edit(DocumentType $documentType)
    {
        return view('document_types.edit', compact('documentType'));
    }

    public function update(Request $request, DocumentType $documentType)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:document_types,code,'.$documentType->id,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $documentType->update($validated);

        return redirect()->route('document-types.index')->with('success', 'Tip dokumenta izmenjen.');
    }

    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();

        return redirect()->route('document-types.index')->with('success', 'Tip dokumenta obrisan.');
    }
}

