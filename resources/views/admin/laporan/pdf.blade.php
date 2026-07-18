<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Sertifikat Tanah</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 4px;
            color: #2E7D32;
        }
        .subtitle {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #2E7D32;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
        }
        td {
            padding: 5px 4px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #999;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        .badge-aktif {
            background: #d4edda;
            color: #155724;
        }
        .badge-lain {
            background: #f8d7da;
            color: #721c24;
        }
        .filter-info {
            font-size: 9px;
            color: #666;
            margin-bottom: 15px;
            padding: 8px;
            background: #f5f5f5;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>LAPORAN SERTIFIKAT TANAH</h1>
    <p class="subtitle">Desa Tegal Mulyo — {{ now()->format('d F Y') }}</p>

    @if(($filters['desa_id'] ?? false) || ($filters['tahun'] ?? false) || ($filters['luas_min'] ?? false) || ($filters['luas_max'] ?? false))
        <div class="filter-info">
            Filter:
            @if($desa) Dusun: {{ $desa->dusun }} @endif
            @if($filters['tahun'] ?? false) | Tahun: {{ $filters['tahun'] }} @endif
            @if($filters['luas_min'] ?? false) | Luas Min: {{ number_format($filters['luas_min'], 0, ',', '.') }} @endif
            @if($filters['luas_max'] ?? false) | Luas Max: {{ number_format($filters['luas_max'], 0, ',', '.') }} @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:18%">Alas Hak</th>
                <th style="width:10%">Luas (M²)</th>
                <th style="width:18%">Pemilik</th>
                <th style="width:12%">Jenis Hak</th>
                <th style="width:10%">Status</th>
                <th style="width:12%">Dusun</th>
                <th style="width:15%">Tgl Input</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sertifikats as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nomor_sertifikat }}</td>
                    <td>{{ number_format($s->luas, 0, ',', '.') }}</td>
                    <td>{{ $s->pemilik->nama ?? '-' }}</td>
                    <td>{{ $s->jenis_hak->nama ?? '-' }}</td>
                    <td>{{ $s->status->nama ?? '-' }}</td>
                    <td>{{ $s->desa->dusun ?? '-' }}</td>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#999;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }} | SIMSETA — Desa Tegal Mulyo</p>
        <p>Total data: {{ $sertifikats->count() }} aset tanah</p>
    </div>
</body>
</html>
