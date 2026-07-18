<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Sertifikat $sertifikat)
    {
        $dokumens = $sertifikat->dokumens()->latest()->get();
        return view('admin.dokumen.index', compact('sertifikat', 'dokumens'));
    }

    public function store(Request $request, Sertifikat $sertifikat)
    {
        $this->authorize('update', $sertifikat);

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'nama_file' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('dokumen/' . $sertifikat->id, 'public');

        $dokumen = Dokumen::create([
            'sertifikat_id' => $sertifikat->id,
            'nama_file' => $request->input('nama_file', $originalName),
            'jenis_file' => $file->getClientOriginalExtension(),
            'path' => $path,
        ]);

        return redirect()->route('admin.sertifikat.show', $sertifikat)
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function destroy(Sertifikat $sertifikat, Dokumen $dokumen)
    {
        $this->authorize('update', $sertifikat);

        Storage::disk('public')->delete($dokumen->path);
        $dokumen->delete();

        return redirect()->route('admin.sertifikat.show', $sertifikat)
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Sertifikat $sertifikat, Dokumen $dokumen)
    {
        return Storage::disk('public')->download($dokumen->path, $dokumen->nama_file);
    }
}
