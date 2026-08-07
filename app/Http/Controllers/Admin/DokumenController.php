<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class DokumenController extends Controller
{
    public function index(Sertifikat $sertifikat)
    {
        $this->authorize('view', $sertifikat);

        // paginate dokumen untuk menghindari memuat banyak file sekaligus
        $dokumens = $sertifikat->dokumens()->latest()->paginate(12);
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
        $ext = strtolower($file->getClientOriginalExtension());
        $allowedExts = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];

        if (!in_array($ext, $allowedExts)) {
            return redirect()->back()->withErrors(['file' => 'Ekstensi file tidak diizinkan demi alasan keamanan.']);
        }
        $originalName = $file->getClientOriginalName();
        $path = $file->store('dokumen/' . $sertifikat->id, 'public');

        // Ensure nama_file is never null: prefer explicit input, then original filename, then stored basename
        $namaFile = $request->filled('nama_file') ? $request->input('nama_file') : ($originalName ?? pathinfo($path, PATHINFO_BASENAME));

        $dokumen = Dokumen::create([
            'sertifikat_id' => $sertifikat->id,
            'nama_file' => $namaFile,
            'jenis_file' => $file->getClientOriginalExtension(),
            'path' => $path,
        ]);

        return redirect()->route('admin.sertifikat.show', $sertifikat)
            ->with('success', 'Dokumen berhasil diupload.');
    }

    public function destroy(Sertifikat $sertifikat, Dokumen $dokumen)
    {
        $this->authorize('update', $sertifikat);

        // Log for debugging whether delete was reached and what path exists
        Log::info('Dokumen destroy called', ['id' => $dokumen->id, 'path' => $dokumen->path]);

        // Only attempt to delete the file if a valid path string exists
        if (!empty($dokumen->path) && is_string($dokumen->path)) {
            if (Storage::disk('public')->exists($dokumen->path)) {
                Storage::disk('public')->delete($dokumen->path);
                Log::info('Dokumen file deleted from storage', ['path' => $dokumen->path]);
            } else {
                Log::warning('Dokumen file not found in storage', ['path' => $dokumen->path]);
            }
        } else {
            Log::warning('Dokumen path empty or invalid', ['path' => $dokumen->path]);
        }

        $dokumen->delete();
        Log::info('Dokumen model deleted', ['id' => $dokumen->id]);

        return redirect()->route('admin.sertifikat.show', $sertifikat)
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Sertifikat $sertifikat, Dokumen $dokumen)
    {
        $this->authorize('view', $sertifikat);

        // Pastikan dokumen memang milik sertifikat ini (mencegah IDOR)
        if ($dokumen->sertifikat_id !== $sertifikat->id) {
            abort(404);
        }

        return response()->download(Storage::disk('public')->path($dokumen->path), $dokumen->nama_file);
    }
}
