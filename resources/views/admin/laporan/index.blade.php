@extends('admin.layout')

@section('title', 'Laporan')
@section('page-heading', 'Laporan Aset Tanah')

@section('content')
<div class="space-y-6">
    <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white p-6 shadow-lg">
        <h2 class="text-xl font-semibold text-[var(--text)] mb-4">Filter Laporan</h2>
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="block text-sm font-semibold text-[var(--text-muted)] mb-1">Dusun</label>
                <select name="desa_id"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/10 focus:border-[var(--primary)]">
                    <option value="">Semua Dusun</option>
                    @foreach($desas as $d)
                        <option value="{{ $d->id }}" {{ request('desa_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->dusun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[var(--text-muted)] mb-1">Tahun Input</label>
                <select name="tahun"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/10 focus:border-[var(--primary)]">
                    <option value="">Semua Tahun</option>
                    @foreach($tahuns as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[var(--text-muted)] mb-1">Luas Min (M²)</label>
                <input type="number" step="0.01" name="luas_min" value="{{ request('luas_min') }}"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/10 focus:border-[var(--primary)]"
                    placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-semibold text-[var(--text-muted)] mb-1">Luas Max (M²)</label>
                <input type="number" step="0.01" name="luas_max" value="{{ request('luas_max') }}"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/10 focus:border-[var(--primary)]"
                    placeholder="999999">
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex gap-3">
                <button type="submit"
                    class="rounded-xl bg-[var(--primary)] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[var(--primary-dark)] transition">
                    <i class="fas fa-search mr-2"></i>Tampilkan
                </button>
                <a href="{{ route('admin.laporan.index') }}"
                    class="rounded-xl border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if($sertifikats->isNotEmpty())
        <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white p-6 shadow-lg">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[var(--text)]">Hasil Laporan</h2>
                    <p class="text-sm text-[var(--text-muted)]">{{ $sertifikats->count() }} data ditemukan</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}"
                        class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                        <i class="fas fa-file-pdf mr-2"></i>PDF
                    </a>
                    <a href="{{ route('admin.laporan.export-excel', request()->query()) }}"
                        class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition">
                        <i class="fas fa-file-excel mr-2"></i>Excel
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">No</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Alas Hak</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Luas (M²)</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Pemilik</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Jenis Hak</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Status</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Dusun</th>
                            <th class="text-left py-3 px-2 font-semibold text-[var(--text-muted)]">Tgl Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sertifikats as $s)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-2">{{ $loop->iteration }}</td>
                                <td class="py-3 px-2 font-medium">{{ $s->nomor_sertifikat }}</td>
                                <td class="py-3 px-2">{{ number_format($s->luas, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">{{ $s->pemilik->nama ?? '-' }}</td>
                                <td class="py-3 px-2">{{ $s->jenis_hak->nama ?? '-' }}</td>
                                <td class="py-3 px-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold
                                        @if($s->status->nama === 'Aktif') bg-green-100 text-green-700
                                        @else bg-red-50 text-red-700 @endif">
                                        {{ $s->status->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-2">{{ $s->desa->dusun ?? '-' }}</td>
                                <td class="py-3 px-2 text-[var(--text-muted)]">{{ $s->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request()->anyFilled(['desa_id', 'tahun', 'luas_min', 'luas_max']))
        <div class="rounded-[2rem] border border-gray-200 bg-white p-8 text-center shadow-lg">
            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Tidak ada data yang sesuai dengan filter yang dipilih.</p>
        </div>
    @else
        <div class="rounded-[2rem] border border-gray-200 bg-white p-8 text-center shadow-lg">
            <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-600">Pilih filter di atas, lalu klik <strong>Tampilkan</strong> untuk melihat data.</p>
        </div>
    @endif
</div>
@endsection
