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
use App\Models\PenggunaanTanah;
use Illuminate\Support\Facades\Cache;
use App\Traits\UsesYearSql;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    use UsesYearSql;

    /**
     * Helper: ambil atau buat Pemilik berdasarkan nama dan detailnya.
     */
    private function getPemilikId(?string $nama, ?string $nik = null, ?string $telepon = null, ?string $alamat = null): int
    {
        $nama = trim($nama ?: 'Umum');

        $pemilik = null;
        if (!empty($nik)) {
            $pemilik = Pemilik::where('nik', $nik)->first();
        }
        if (!$pemilik) {
            $pemilik = Pemilik::where('nama', $nama)->first();
        }

        if (!$pemilik) {
            if (empty($nik)) {
                do {
                    $nik = str_pad(mt_rand(1, 999999999999), 16, '0', STR_PAD_LEFT);
                } while (Pemilik::where('nik', $nik)->exists());
            }

            $pemilik = Pemilik::create([
                'nama' => $nama,
                'nik' => $nik,
                'telepon' => $telepon,
                'alamat' => $alamat
            ]);
        } else {
            // Update existing if blank
            $updates = [];
            if (empty($pemilik->nik) && !empty($nik))
                $updates['nik'] = $nik;
            if (empty($pemilik->telepon) && !empty($telepon))
                $updates['telepon'] = $telepon;
            if (empty($pemilik->alamat) && !empty($alamat))
                $updates['alamat'] = $alamat;
            if (count($updates) > 0)
                $pemilik->update($updates);
        }

        return $pemilik->id;
    }

    /**
     * Helper: ambil atau buat JenisHakTanah berdasarkan nama.
     */
    private function getJenisHakId(?string $nama): int
    {
        return JenisHakTanah::firstOrCreate(['nama' => trim($nama ?: 'Hak Milik')])->id;
    }

    /**
     * Helper: ambil atau buat StatusSertifikat berdasarkan nama.
     */
    private function getStatusId(?string $nama): int
    {
        return StatusSertifikat::firstOrCreate(['nama' => trim($nama ?: 'Aktif')])->id;
    }

    /* ═══════════════════════════════════════════════════════ */

    public function index(Request $request)
    {
        $this->authorize('viewAny', Sertifikat::class);

        $desas = Cache::remember('desas_all', 3600, function () {
            return Desa::all()->toArray();
        });
        $desas = collect($desas)->map(fn($d) => is_array($d) ? (object) $d : $d);
        $query = Sertifikat::with(['pemilik', 'jenis_hak', 'status', 'desa']);

        if ($request->filled('desa_id'))
            $query->where('desa_id', $request->desa_id);
        if ($request->filled('tahun'))
            $query->whereYear('created_at', $request->tahun);
        if ($request->filled('kategori'))
            $query->where('kategori', $request->kategori);

        if ($request->filled('search')) {
            $s = $request->query('search');
            // Gunakan JOIN langsung ke tabel pemiliks (lebih efisien dari orWhereHas subquery)
            $pemilikIds = Pemilik::where('nama', 'like', "%$s%")->pluck('id');
            $query->where(function ($q) use ($s, $pemilikIds) {
                $q->where('nomor_sertifikat', 'like', "%$s%")
                  ->orWhereIn('pemilik_id', $pemilikIds);
            });
        }

        $tahuns = Sertifikat::selectRaw($this->yearSql() . ' as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        $sertifikats = $query->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(15);

        return view('admin.sertifikat.index', compact('sertifikats', 'desas', 'tahuns'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Sertifikat::class);

        $desasForForm = Cache::remember('desas_all', 3600, function () {
            return Desa::all()->toArray();
        });
        $desasForForm = collect($desasForForm)->map(fn($d) => is_array($d) ? (object) $d : $d);

        $penggunaanTanahs = PenggunaanTanah::orderBy('nama', 'asc')->get();

        return view('admin.sertifikat.create', [
            'desas' => $desasForForm,
            'default_kategori' => $request->query('kategori', 'masyarakat'),
            'penggunaanTanahs' => $penggunaanTanahs,
        ]);
    }

    public function store(StoreSertifikatRequest $request)
    {
        $this->authorize('create', Sertifikat::class);

        $v = $request->validated();

        $kategori = $v['kategori'] ?? 'masyarakat';

        if ($kategori === 'kas_desa') {
            $pemilikNama = 'Pemerintah Desa Tegalmulyo';
            $pemilikId = $this->getPemilikId($pemilikNama);
        } else {
            $pemilikNama = $v['pemilik_nama'] ?? 'Umum';
            $pemilikId = $this->getPemilikId($pemilikNama, $v['nik'] ?? null, $v['telepon'] ?? null, $v['alamat_pemilik'] ?? null);
        }

        // Derive status_pemanfaatan from status_nama for dashboard/laporan queries
        $statusNama = $v['status_nama'] ?? 'Aktif';
        $statusPemanfaatan = null;
        if ($kategori === 'kas_desa') {
            if (strtolower($statusNama) === 'disewakan') {
                $statusPemanfaatan = 'Disewakan';
            } elseif (in_array(strtolower($statusNama), ['kosong', 'tidak terpakai'])) {
                $statusPemanfaatan = 'Kosong';
            } else {
                $statusPemanfaatan = 'Dipakai Pemerintah Desa';
            }
        }

        $jenisHakId = $this->getJenisHakId($v['jenis_hak_nama']);
        $statusId = $this->getStatusId($statusNama);
        $desaId = $v['desa_id'] ?? Desa::first()?->id ?? 1;

        Sertifikat::create([
            'nomor_sertifikat' => $v['nomor_sertifikat'],
            'nib' => $v['nib'] ?? null,
            'pemilik_id' => $pemilikId,
            'jenis_hak_id' => $jenisHakId,
            'status_id' => $statusId,
            'desa_id' => $desaId,
            'luas' => $v['luas'],
            'kategori' => $kategori,
            'status_pemanfaatan' => $statusPemanfaatan,

            // Lokasi
            'rt_rw' => $v['rt_rw'] ?? null,
            'alamat' => $v['alamat'] ?? null,
            'blok' => $v['blok'] ?? null,
            'persil' => $v['persil'] ?? null,
            'latitude' => $v['latitude'] ?? null,
            'longitude' => $v['longitude'] ?? null,

            // Fisik
            'penggunaan_tanah' => $v['penggunaan_tanah'] ?? null,

            // Pengelola TKD
            'penanggung_jawab' => $v['penanggung_jawab'] ?? null,
            'jabatan' => $v['jabatan'] ?? null,
            'unit_pengelola' => $v['unit_pengelola'] ?? null,
        ]);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Aset tanah berhasil ditambahkan.');
    }

    public function show(Sertifikat $sertifikat)
    {
        $this->authorize('view', $sertifikat);

        $sertifikat->load(['pemilik', 'jenis_hak', 'status', 'desa', 'dokumens']);
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        $this->authorize('update', $sertifikat);

        $desasForForm = Cache::remember('desas_all', 3600, function () {
            return Desa::all()->toArray();
        });
        $desasForForm = collect($desasForForm)->map(fn($d) => is_array($d) ? (object) $d : $d);

        $penggunaanTanahs = PenggunaanTanah::orderBy('nama', 'asc')->get();

        return view('admin.sertifikat.edit', [
            'sertifikat' => $sertifikat->load(['pemilik', 'jenis_hak', 'status', 'desa']),
            'desas' => $desasForForm,
            'penggunaanTanahs' => $penggunaanTanahs,
        ]);
    }

    public function update(UpdateSertifikatRequest $request, Sertifikat $sertifikat)
    {
        $this->authorize('update', $sertifikat);

        $v = $request->validated();

        $kategori = $v['kategori'] ?? 'masyarakat';

        if ($kategori === 'kas_desa') {
            $pemilikNama = 'Pemerintah Desa Tegalmulyo';
            $pemilikId = $this->getPemilikId($pemilikNama);
        } else {
            $pemilikNama = $v['pemilik_nama'] ?? 'Umum';
            $pemilikId = $this->getPemilikId($pemilikNama, $v['nik'] ?? null, $v['telepon'] ?? null, $v['alamat_pemilik'] ?? null);
        }

        $statusNama = $request->input('status_nama', 'Aktif');
        $statusPemanfaatan = null;
        if ($kategori === 'kas_desa') {
            if (strtolower($statusNama) === 'disewakan') {
                $statusPemanfaatan = 'Disewakan';
            } elseif (in_array(strtolower($statusNama), ['kosong', 'tidak terpakai'])) {
                $statusPemanfaatan = 'Kosong';
            } else {
                $statusPemanfaatan = 'Dipakai Pemerintah Desa';
            }
        }

        $data = $v;
        unset(
            $data['pemilik_nama'],
            $data['jenis_hak_nama'],
            $data['status_nama'],
            $data['nik'],
            $data['telepon'],
            $data['alamat_pemilik']
        );

        $sertifikat->update(array_merge($data, [
            'pemilik_id' => $pemilikId,
            'jenis_hak_id' => $this->getJenisHakId($request->input('jenis_hak_nama')),
            'status_id' => $this->getStatusId($request->input('status_nama')),
            'status_pemanfaatan' => $statusPemanfaatan,
        ]));

        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Aset tanah berhasil diperbarui.');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        $this->authorize('delete', $sertifikat);

        $sertifikat->delete();
        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Aset tanah berhasil dihapus.');
    }

    public function restore($id)
    {
        $sertifikat = Sertifikat::withTrashed()->findOrFail($id);
        $this->authorize('restore', $sertifikat);

        $sertifikat->restore();
        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Aset tanah berhasil dipulihkan.');
    }
}
