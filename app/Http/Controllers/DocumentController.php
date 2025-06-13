<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            Document::create([
                'title' => $request->title,
                'file_path' => $filePath,
                'original_name' => $file->getClientOriginalName()
            ]);

            return redirect()->route('documents.index')
                ->with('success', 'PDF uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    public function show(Document $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
        ]);
    }

    public function destroy(Document $document)
    {
        Storage::delete('public/' . $document->file_path);
        $document->delete();
        
        return redirect()->route('documents.index')
            ->with('success', 'PDF deleted successfully.');
    }
}
