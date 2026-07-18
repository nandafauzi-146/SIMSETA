<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sertifikat' => Sertifikat::count(),
            'sertifikat_aktif' => Sertifikat::whereHas('status', function ($q) {
                $q->where('nama', 'Aktif');
            })->count(),
            'total_pemilik' => Pemilik::count(),
            'total_pengguna' => User::count(),
        ];

        // Chart data: sertifikat per month (last 6 months)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $count = Sertifikat::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyData[] = $count;
        }

        // Chart data: sertifikat per dusun
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

        return view('admin.dashboard', array_merge($stats, [
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'dusunLabels' => $dusunLabels,
            'dusunData' => $dusunData,
            'dusunColors' => $dusunColors,
        ]));
    }
}
