<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSertifikatRequest;
use App\Http\Requests\UpdateSertifikatRequest;
use App\Models\Sertifikat;
use App\Models\Pemilik;
use App\Models\JenisHakTanah;
use App\Models\StatusSertifikat;
use App\Models\Desa;
use App\Traits\UsesYearSql;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    use UsesYearSql;
    /**
     * Display a listing of certificates.
     */
    public function index(Request $request)
    {
        $desas = Desa::all();
        $query = Sertifikat::with(['pemilik', 'jenis_hak', 'status', 'desa']);

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sertifikat', 'like', "%$search%")
                    ->orWhereHas('pemilik', function ($pq) use ($search) {
                        $pq->where('nama', 'like', "%$search%");
                    });
            });
        }

        $tahuns = Sertifikat::selectRaw($this->yearSql() . ' as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $sertifikats = $query->orderBy('created_at', 'asc')->orderBy('id', 'asc')->paginate(15);

        return view('admin.sertifikat.index', compact('sertifikats', 'desas', 'tahuns'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create()
    {
        $data = [
            'pemiliks'  => Pemilik::all(),
            'jenis_haks'=> JenisHakTanah::all(),
            'statuses'  => StatusSertifikat::all(),
            'desas'     => Desa::all(),
        ];

        return view('admin.sertifikat.create', $data);
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(StoreSertifikatRequest $request)
    {
        $validated = $request->validated();

        $pemilikId = $validated['pemilik_id'] ?? Pemilik::first()?->id ?? Pemilik::create([
            'nama' => 'Umum',
            'nik' => '0000000000000000',
        ])->id;
        $jenisHakId = $validated['jenis_hak_id'] ?? JenisHakTanah::first()?->id ?? 1;
        $statusId = $validated['status_id'] ?? StatusSertifikat::first()?->id ?? 1;
        $desaId = $validated['desa_id'] ?? Desa::first()?->id ?? 1;

        $created = 0;
        foreach ($validated['items'] as $item) {
            $data = [
                'nomor_sertifikat' => $item['nomor_sertifikat'],
                'pemilik_id' => $pemilikId,
                'jenis_hak_id' => $jenisHakId,
                'status_id' => $statusId,
                'desa_id' => $desaId,
                'luas' => $item['luas_tanah'],
                'alamat' => $item['deskripsi'] ?? null,
            ];

            Sertifikat::create($data);
            $created++;
        }

        return redirect()->route('admin.sertifikat.index')
            ->with('success', $created > 1
                ? "{$created} sertifikat berhasil ditambahkan."
                : 'Sertifikat berhasil ditambahkan.');
    }

    /**
     * Display the specified certificate.
     */
    public function show(Sertifikat $sertifikat)
    {
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(Sertifikat $sertifikat)
    {
        $data = [
            'sertifikat' => $sertifikat,
            'pemiliks' => Pemilik::all(),
            'jenis_haks' => JenisHakTanah::all(),
            'statuses' => StatusSertifikat::all(),
            'desas' => Desa::all(),
        ];

        return view('admin.sertifikat.edit', $data);
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(UpdateSertifikatRequest $request, Sertifikat $sertifikat)
    {
        $validated = $request->validated();
        $sertifikat->update($validated);

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        $this->authorize('delete', $sertifikat);
        $sertifikat->delete();

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function restore($id)
    {
        $sertifikat = Sertifikat::withTrashed()->findOrFail($id);
        $this->authorize('restore', $sertifikat);
        $sertifikat->restore();

        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat berhasil dipulihkan.');
    }

}
