@extends('admin.layout')

@section('title', 'Detail Aset Tanah')

@section('content')
    @php
        $isKasDesa = $sertifikat->kategori === 'kas_desa';
        $isAktif = ($sertifikat->status->nama ?? null) === 'Aktif';
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">

        <x-admin.page-header title="Detail Aset Tanah"
            description="Tinjau data aset tanah desa secara lengkap sebelum melakukan pembaruan atau pencatatan lanjutan.">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.sertifikat.edit', $sertifikat) }}"
                    class="inline-flex items-center gap-2 rounded-full bg-[var(--accent)] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--accent-light)]">
                    <i class="fas fa-edit text-xs"></i>Edit
                </a>
                <a href="{{ route('admin.sertifikat.index') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-5 py-2.5 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                    <i class="fas fa-arrow-left text-xs"></i>Kembali
                </a>
            </div>
        </x-admin.page-header>

        {{-- ═══ HEADER CARD ═══ --}}
        <div class="overflow-hidden rounded-3xl border border-[var(--primary)]/15 bg-white shadow-lg">
            <div class="bg-gradient-to-r from-[var(--primary-dark)] to-[var(--primary)] px-6 py-6 text-white sm:px-8">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="mb-1 text-xs font-semibold uppercase tracking-[0.2em] text-white/60">
                            Nomor Sertifikat / Alas Hak
                        </p>
                        <h2 class="break-words text-2xl font-bold tracking-tight sm:text-3xl">
                            {{ $sertifikat->nomor_sertifikat }}
                        </h2>
                        <p class="mt-1 text-sm text-white/70">
                            Jenis Hak: <span class="font-semibold text-white">{{ $sertifikat->jenis_hak->nama ?? '-' }}</span>
                            @if($sertifikat->nib)
                                <span class="mx-2 text-white/40">|</span> NIB: <span class="font-semibold text-white">{{ $sertifikat->nib }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full border px-4 py-1.5 text-sm font-semibold
                            {{ $isKasDesa ? 'border-amber-300/30 bg-amber-400/20 text-amber-200' : 'border-white/20 bg-white/15 text-white' }}">
                            <i class="fas {{ $isKasDesa ? 'fa-landmark' : 'fa-user' }} text-xs"></i>
                            {{ $sertifikat->kategori_label }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full border px-4 py-1.5 text-sm font-semibold
                            {{ $isAktif ? 'border-emerald-300/30 bg-emerald-400/20 text-emerald-200' : 'border-white/20 bg-white/10 text-white/80' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $isAktif ? 'bg-emerald-300' : 'bg-white/50' }}"></span>
                            {{ $sertifikat->status->nama ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 divide-x divide-y divide-slate-100 sm:grid-cols-4 sm:divide-y-0">
                @foreach ([
                    ['label' => 'Luas Tanah', 'value' => number_format((float) $sertifikat->luas, 0, ',', '.') . ' m²', 'accent' => true],
                    ['label' => 'Penggunaan', 'value' => $sertifikat->penggunaan_tanah ?? '-'],
                    ['label' => 'Dukuh', 'value' => $sertifikat->desa->dusun ?? '-'],
                    ['label' => 'Tanggal Input', 'value' => $sertifikat->created_at->format('d M Y')],
                ] as $stat)
                    <div class="px-4 py-4 text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[var(--text-muted)]">
                            {{ $stat['label'] }}
                        </p>
                        <p class="mt-1 truncate text-sm font-bold {{ ($stat['accent'] ?? false) ? 'text-lg text-[var(--primary)]' : 'text-[var(--text)]' }}">
                            {{ $stat['value'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">

            {{-- ═══ B. DATA PEMILIK / PENGELOLA ═══ --}}
            <div class="rounded-3xl border {{ $isKasDesa ? 'border-amber-200 bg-amber-50/40' : 'border-[var(--primary)]/15 bg-white' }} p-6 shadow-lg">
                <h3 class="mb-4 flex items-center gap-2 border-b {{ $isKasDesa ? 'border-amber-200 text-amber-800' : 'border-slate-100 text-[var(--primary)]' }} pb-3 text-sm font-bold uppercase tracking-wider">
                    <i class="fas {{ $isKasDesa ? 'fa-landmark' : 'fa-user' }}"></i>
                    B. {{ $isKasDesa ? 'Data Pengelola (Kas Desa)' : 'Data Pemilik (Warga)' }}
                </h3>

                <dl class="space-y-2">
                    @if ($isKasDesa)
                        @foreach ([
                            'Penanggung Jawab' => $sertifikat->penanggung_jawab ?? '-',
                            'Jabatan' => $sertifikat->jabatan ?? '-',
                            'Unit Pengelola' => $sertifikat->unit_pengelola ?? '-',
                        ] as $label => $value)
                            <div class="grid grid-cols-[110px_1fr] gap-3 rounded-xl bg-white px-4 py-3 sm:grid-cols-[130px_1fr]">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-amber-700">{{ $label }}</dt>
                                <dd class="text-right text-sm font-semibold text-[var(--text)]">{{ $value }}</dd>
                            </div>
                        @endforeach
                    @else
                        @foreach ([
                            'NIK' => $sertifikat->pemilik->nik ?? '-',
                            'Nama Pemilik' => $sertifikat->pemilik->nama ?? '-',
                            'Alamat Pemilik' => $sertifikat->pemilik->alamat ?? '-',
                        ] as $label => $value)
                            <div class="grid grid-cols-[110px_1fr] gap-3 rounded-xl bg-[var(--bg)]/50 px-4 py-3 sm:grid-cols-[130px_1fr]">
                                <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--text-muted)]">{{ $label }}</dt>
                                <dd class="text-right text-sm font-medium text-[var(--text)]">{{ $value }}</dd>
                            </div>
                        @endforeach
                    @endif
                </dl>
            </div>

            {{-- ═══ C. LOKASI TANAH ═══ --}}
            <div class="rounded-3xl border border-[var(--primary)]/15 bg-white p-6 shadow-lg">
                <h3 class="mb-4 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm font-bold uppercase tracking-wider text-[var(--primary)]">
                    <i class="fas fa-map-marker-alt"></i>C. Lokasi Tanah
                </h3>

                <dl class="space-y-2">
                    @foreach ([
                        'Dukuh' => $sertifikat->desa->dusun ?? '-',
                        'RT / RW' => $sertifikat->rt_rw ?? '-',
                        'Blok' => $sertifikat->blok ?? '-',
                        'Persil' => $sertifikat->persil ?? '-',
                    ] as $label => $value)
                        <div class="grid grid-cols-[110px_1fr] gap-3 rounded-xl bg-[var(--bg)]/50 px-4 py-3 sm:grid-cols-[130px_1fr]">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--text-muted)]">{{ $label }}</dt>
                            <dd class="text-right text-sm font-medium text-[var(--text)]">{{ $value }}</dd>
                        </div>
                    @endforeach

                    @if ($sertifikat->alamat)
                        <div class="grid grid-cols-[110px_1fr] gap-3 rounded-xl bg-[var(--bg)]/50 px-4 py-3 sm:grid-cols-[130px_1fr]">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--text-muted)]">Alamat</dt>
                            <dd class="text-right text-sm font-medium text-[var(--text)]">{{ $sertifikat->alamat }}</dd>
                        </div>
                    @endif

                    @if ($sertifikat->latitude && $sertifikat->longitude)
                        <div class="grid grid-cols-[110px_1fr] items-center gap-3 rounded-xl bg-[var(--bg)]/50 px-4 py-3 sm:grid-cols-[130px_1fr]">
                            <dt class="text-xs font-semibold uppercase tracking-wider text-[var(--text-muted)]">Koordinat</dt>
                            <dd class="text-right">
                                <a href="https://maps.google.com/?q={{ $sertifikat->latitude }},{{ $sertifikat->longitude }}"
                                    target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:underline">
                                    <i class="fas fa-map-pin text-xs"></i>
                                    {{ number_format($sertifikat->latitude, 6) }}, {{ number_format($sertifikat->longitude, 6) }}
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>



        {{-- ═══ DOKUMEN ═══ --}}
        <div class="rounded-3xl border border-[var(--primary)]/15 bg-white p-6 shadow-lg">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-[var(--primary)]">
                    <i class="fas fa-folder-open"></i>Dokumen ({{ $sertifikat->dokumens->count() }})
                </h3>
                <a href="{{ route('admin.sertifikat.dokumen.index', $sertifikat) }}"
                    class="inline-flex items-center gap-1 text-xs font-semibold text-[var(--primary)] hover:underline">
                    Kelola Dokumen <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if ($sertifikat->dokumens->isNotEmpty())
                <div class="space-y-2">
                    @foreach ($sertifikat->dokumens as $dokumen)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-[var(--bg)]/50 p-3 transition hover:border-[var(--primary)]/30">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[var(--primary)]/10 text-[var(--primary)]">
                                    <i class="fas fa-file text-sm"></i>
                                </div>
                                <span class="truncate text-sm font-medium text-[var(--text)]">{{ $dokumen->nama_file }}</span>
                            </div>
                            <a href="{{ route('admin.sertifikat.dokumen.download', [$sertifikat, $dokumen]) }}"
                                class="inline-flex shrink-0 items-center gap-1.5 rounded-xl bg-[var(--primary)]/10 px-4 py-2 text-xs font-semibold text-[var(--primary)] transition hover:bg-[var(--primary)] hover:text-white">
                                <i class="fas fa-download text-xs"></i>Unduh
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <a href="{{ route('admin.sertifikat.dokumen.index', $sertifikat) }}"
                    class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-[var(--primary)]/20 p-8 text-center text-sm font-semibold text-[var(--text-muted)] transition hover:border-[var(--primary)] hover:bg-[var(--primary)]/5 hover:text-[var(--primary)]">
                    <i class="fas fa-cloud-upload-alt mb-1 text-2xl opacity-50"></i>
                    Belum ada dokumen. Klik di sini untuk upload.
                </a>
            @endif
        </div>

    </div>
@endsection