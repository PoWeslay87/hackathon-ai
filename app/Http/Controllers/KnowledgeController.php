<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgeDocument;

class KnowledgeController extends Controller
{
    public function index()
    {
        $documents = KnowledgeDocument::where('is_active', true)->latest()->get();
        return view('admin.knowledge', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        KnowledgeDocument::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Pengetahuan baru berhasil ditambahkan ke "Otak" AI!');
    }
    
    public function destroy($id)
    {
        $doc = KnowledgeDocument::findOrFail($id);
        $doc->delete();
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function edit() {
        // Not used due to single page UI, but good to have
    }
    
    public function update() {
        // Not used
    }
}
