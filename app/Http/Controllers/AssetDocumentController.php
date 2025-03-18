<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetDocument;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;

class AssetDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = AssetDocument::with(['asset', 'uploadedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('asset-documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::all();
        return view('asset-documents.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_code' => 'required|unique:asset_documents',
            'asset_id' => 'required|exists:assets,id',
            'type' => 'required|in:invoice,warranty,insurance,certification,calibration,manual,maintenance_record,inspection_report,disposal_document,purchase_order,contract,other',
            'title' => 'required|string|max:255',
            'document' => 'required|file|max:10240',
            'document_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:document_date',
            'description' => 'nullable|string'
        ]);

        $file = $request->file('document');
        $path = $file->store('documents');

        AssetDocument::create([
            'document_code' => $request->document_code,
            'asset_id' => $request->asset_id,
            'type' => $request->type,
            'title' => $request->title,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'description' => $request->description,
            'document_date' => $request->document_date,
            'expiration_date' => $request->expiration_date,
            'status' => 'active',
            'uploaded_by' => auth()->id() ?? 1,
            'revision_number' => 1
        ]);

        return redirect()->back()->with('success', 'Documento anexado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = AssetDocument::findOrFail($id);
        return view('asset-documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = AssetDocument::findOrFail($id);
        return view('asset-documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = AssetDocument::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'document_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:document_date',
            'requires_renewal' => 'boolean',
            'is_confidential' => 'boolean',
            'status' => 'required|in:active,expired,pending'
        ]);

        $document->update($validated);
        return redirect()->route('asset-documents.show', $id)
            ->with('success', 'Documento atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = AssetDocument::findOrFail($id);
        $document->delete();

        return redirect()->route('asset-documents.index')
            ->with('success', 'Documento removido com sucesso');
    }

    public function download(string $id)
    {
        $document = AssetDocument::findOrFail($id);
        return Storage::download($document->file_path, $document->file_name);
    }
}
