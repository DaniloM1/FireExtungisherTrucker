<?php

namespace App\Http\Controllers\Exam;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class PrivateDocumentController extends Controller
{
    public function show($filename)
    {
        $path = 'documents_private/' . $filename;

        if (!Storage::exists($path)) {
            abort(404);
        }

        return Storage::response($path);
    }
}
