@extends('admin.layout')

@section('title', 'Detail Aset Tanah')

@section('content')
    <div class="mx-auto max-w-4xl">
        <x-admin.page-header title="Detail Aset Tanah"
            description="Tinjau data aset tanah desa secara ringkas sebelum melakukan pembaruan atau pencatatan lanjutan.">
            <a href="{{ route('admin.sertifikat.edit', $sertifikat) }}"
                class="inline-flex items-center gap-2 rounded-3xl bg-[var(--accent)] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--accent-light)]">
                <i class="fas fa-edit"></i>Edit
            </a>
            <a href="{{ route('admin.sertifikat.index') }}"
                class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                <i class="fas fa-arrow-left"></i>Kembali
            </a>
        </x-admin.page-header>

        <x-admin.form-card>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[var(--text-muted)]">Alas Hak / Bukti Kepemilikan</p>
                    <p class="mt-1 text-2xl font-semibold text-[var(--text)]">{{ $sertifikat->nomor_sertifikat }}</p>
                </div>
                <span
                    class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $sertifikat->status->nama === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-[var(--accent)]/10 text-[var(--accent)] border border-[var(--accent)]/20' }}">
                    {{ $sertifikat->status->nama ?? '-' }}
                </span>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-[var(--bg)]/50 p-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Referensi Pemilik</p>
                    <p class="mt-1 text-lg font-semibold text-[var(--text)]">{{ $sertifikat->pemilik->nama ?? '-' }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-[var(--bg)]/50 p-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Jenis Hak</p>
                    <p class="mt-1 text-lg font-semibold text-[var(--text)]">{{ $sertifikat->jenis_hak->nama ?? '-' }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-[var(--bg)]/50 p-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Dusun / Lokasi</p>
                    <p class="mt-1 text-lg font-semibold text-[var(--text)]">{{ $sertifikat->desa->nama ?? '-' }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-[var(--bg)]/50 p-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Luas (M²)</p>
                    <p class="mt-1 text-lg font-semibold text-[var(--text)]">
                        {{ number_format((float) $sertifikat->luas, 0, ',', '.') }} m²
                    </p>
                </div>
            </div>

            @if ($sertifikat->alamat)
                <div class="mt-6 rounded-2xl border border-slate-200 bg-[var(--bg)]/50 p-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Keterangan</p>
                    <p class="mt-1 whitespace-pre-line text-[var(--text)]">{{ $sertifikat->alamat }}</p>
                </div>
            @endif
        </x-admin.form-card>

        <x-admin.form-card class="mt-6">
            @if($sertifikat->dokumens->isNotEmpty())
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-[var(--text)]">Dokumen ({{ $sertifikat->dokumens->count() }})</h3>
                    <a href="{{ route('admin.sertifikat.dokumen.index', $sertifikat) }}"
                        class="text-sm font-semibold text-[var(--primary)] hover:underline">Kelola</a>
                </div>
                <div class="space-y-2">
                    @foreach($sertifikat->dokumens as $d)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-[var(--bg)]/50 p-3">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-file text-[var(--primary)]"></i>
                                <span class="text-sm text-[var(--text)]">{{ $d->nama_file }}</span>
                            </div>
                            <a href="{{ route('admin.sertifikat.dokumen.download', [$sertifikat, $d]) }}"
                                class="text-sm text-blue-600 hover:underline">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <a href="{{ route('admin.sertifikat.dokumen.index', $sertifikat) }}"
                    class="inline-flex items-center gap-2 rounded-3xl border border-dashed border-[var(--primary)]/30 px-5 py-3 text-sm font-semibold text-[var(--primary)] transition hover:border-[var(--primary)] hover:bg-[var(--primary)]/5">
                    <i class="fas fa-upload"></i>Upload Dokumen
                </a>
            @endif
        </x-admin.form-card>
    </div>
@endsection
