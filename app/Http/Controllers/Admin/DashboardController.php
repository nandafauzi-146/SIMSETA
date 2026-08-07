<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Traits\UsesYearSql;

class DashboardController extends Controller
{
    use UsesYearSql;

    public function index()
    {
        // Cache dashboard computations briefly to reduce DB load on frequent page reloads
        $dashboard = Cache::remember('dashboard_overview', 30, function () {
            // ── Overview Stats ──────────────────────────
            $stats = [
                'total_sertifikat' => Sertifikat::count(),
                'sertifikat_aktif' => Sertifikat::whereHas('status', function ($q) {
                    $q->where('nama', 'Aktif');
                })->count(),
                'total_pemilik' => Pemilik::count(),
                'total_pengguna' => User::count(),
            ];

            // ── Masyarakat Stats ────────────────────────
            $masyarakat = [
                'total' => Sertifikat::masyarakat()->count(),
                'luas' => Sertifikat::masyarakat()->sum('luas'),
                'aktif' => Sertifikat::masyarakat()->whereHas('status', fn($q) => $q->where('nama', 'Aktif'))->count(),
            ];

            // ── Kas Desa Stats ──────────────────────────
            $kasDesa = [
                'total' => Sertifikat::kasDesa()->count(),
                'luas' => Sertifikat::kasDesa()->sum('luas'),
                'disewakan' => Sertifikat::kasDesa()->where('status_pemanfaatan', 'Disewakan')->count(),
                'dipakai' => Sertifikat::kasDesa()->where('status_pemanfaatan', 'Dipakai Pemerintah Desa')->count(),
                'kosong' => Sertifikat::kasDesa()->where('status_pemanfaatan', 'Kosong')->count(),
            ];

            // ── Chart: Tren Bulanan — 1 query GROUP BY (menggantikan 12 query looping) ──
            $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
            $monthlyRaw = Sertifikat::selectRaw(
                    "kategori, {$this->yearMonthSql()} as ym, COUNT(*) as total"
                )
                ->where('created_at', '>=', $sixMonthsAgo)
                ->whereIn('kategori', ['masyarakat', 'kas_desa'])
                ->groupBy('kategori', 'ym')
                ->orderBy('ym')
                ->get()
                ->groupBy(fn($r) => $r->ym);

            $monthlyLabels = [];
            $monthlyMasyarakat = [];
            $monthlyKasDesa = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $key   = $date->format('Y-m');
                $monthlyLabels[]     = $date->format('M Y');
                $group = $monthlyRaw->get($key, collect());
                $monthlyMasyarakat[] = (int) ($group->firstWhere('kategori', 'masyarakat')?->total ?? 0);
                $monthlyKasDesa[]    = (int) ($group->firstWhere('kategori', 'kas_desa')?->total ?? 0);
            }

            // ── Chart: Distribusi per Dusun ──
            $dusunLabels = [];
            $dusunData = [];
            $dusunColors = [];
            $colors = ['#2E7D32', '#66BB6A', '#C89B53', '#4CAF50', '#81C784', '#A5D6A7', '#388E3C', '#1B5E20'];
            $perDusun = Sertifikat::select('desa_id', DB::raw('count(*) as total'))
                ->with('desa')
                ->groupBy('desa_id')
                ->get();
            foreach ($perDusun as $i => $item) {
                $dusunLabels[] = $item->desa->dusun ?? $item->desa->nama ?? 'Unknown';
                $dusunData[] = $item->total;
                $dusunColors[] = $colors[$i % count($colors)];
            }

            // ── Chart: Komposisi Pribadi vs Kas Desa ──
            $komposisiLabels = ['Tanah Pribadi', 'Tanah Kas Desa'];
            $komposisiData = [$masyarakat['total'], $kasDesa['total']];
            $komposisiColors = ['#2E7D32', '#C89B53'];

            // ── Chart: Distribusi Penggunaan Tanah ──
            $penggunaanLabels = [];
            $penggunaanData = [];
            $penggunaanColors = [];
            $penggunaanPalette = ['#2E7D32', '#C89B53', '#1565C0', '#E65100', '#6A1B9A', '#00838F', '#AD1457', '#FF8F00', '#2E7D32', '#5D4037'];
            $perPenggunaan = Sertifikat::select('penggunaan_tanah', DB::raw('count(*) as total'))
                ->whereNotNull('penggunaan_tanah')
                ->where('penggunaan_tanah', '!=', '')
                ->groupBy('penggunaan_tanah')
                ->orderByDesc('total')
                ->get();
            foreach ($perPenggunaan as $i => $item) {
                $penggunaanLabels[] = $item->penggunaan_tanah;
                $penggunaanData[] = $item->total;
                $penggunaanColors[] = $penggunaanPalette[$i % count($penggunaanPalette)];
            }
            $totalPenggunaan = array_sum($penggunaanData);

            return compact(
                'stats',
                'masyarakat',
                'kasDesa',
                'monthlyLabels',
                'monthlyMasyarakat',
                'monthlyKasDesa',
                'dusunLabels',
                'dusunData',
                'dusunColors',
                'komposisiLabels',
                'komposisiData',
                'komposisiColors',
                'penggunaanLabels',
                'penggunaanData',
                'penggunaanColors',
                'totalPenggunaan'
            );
        });

        $stats = $dashboard['stats'];
        $masyarakat = $dashboard['masyarakat'];
        $kasDesa = $dashboard['kasDesa'];
        $monthlyLabels = $dashboard['monthlyLabels'];
        $monthlyMasyarakat = $dashboard['monthlyMasyarakat'];
        $monthlyKasDesa = $dashboard['monthlyKasDesa'];
        $dusunLabels = $dashboard['dusunLabels'];
        $dusunData = $dashboard['dusunData'];
        $dusunColors = $dashboard['dusunColors'];
        $komposisiLabels = $dashboard['komposisiLabels'];
        $komposisiData = $dashboard['komposisiData'];
        $komposisiColors = $dashboard['komposisiColors'];
        $penggunaanLabels = $dashboard['penggunaanLabels'];
        $penggunaanData = $dashboard['penggunaanData'];
        $penggunaanColors = $dashboard['penggunaanColors'];
        $totalPenggunaan = $dashboard['totalPenggunaan'];

        $sewaAkanBerakhir = collect();

        return view('admin.dashboard', array_merge($stats, [
            'masyarakat' => $masyarakat,
            'kasDesa' => $kasDesa,
            'sewaAkanBerakhir' => $sewaAkanBerakhir,
            'monthlyLabels' => $monthlyLabels,
            'monthlyMasyarakat' => $monthlyMasyarakat,
            'monthlyKasDesa' => $monthlyKasDesa,
            'dusunLabels' => $dusunLabels,
            'dusunData' => $dusunData,
            'dusunColors' => $dusunColors,
            'komposisiLabels' => $komposisiLabels,
            'komposisiData' => $komposisiData,
            'komposisiColors' => $komposisiColors,
            'penggunaanLabels' => $penggunaanLabels,
            'penggunaanData' => $penggunaanData,
            'penggunaanColors' => $penggunaanColors,
            'totalPenggunaan' => $totalPenggunaan,
        ]));
    }
}
