@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@php
    $hour = (int) now()->format('H');
    if ($hour >= 5 && $hour < 11) {
        $greeting = 'Selamat Pagi';
        $greetingIcon = 'fas fa-sun';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat Siang';
        $greetingIcon = 'fas fa-cloud-sun';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat Sore';
        $greetingIcon = 'fas fa-cloud-sun';
    } else {
        $greeting = 'Selamat Malam';
        $greetingIcon = 'fas fa-moon';
    }
@endphp

@section('content')
    <div class="space-y-6">

        {{-- ══════════ HERO SECTION ══════════ --}}
        <section
            class="dash-hero relative overflow-hidden rounded-2xl bg-gradient-to-br from-[var(--primary-dark)] via-[var(--primary)] to-[var(--secondary)] p-6 text-white shadow-lg lg:p-8">
            {{-- Decorative background elements --}}
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_50%)]"></div>
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/5 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-20 -left-20 h-48 w-48 rounded-full bg-[var(--accent)]/10 blur-2xl"></div>

            <div class="relative grid gap-6 lg:grid-cols-5">
                {{-- Left: Greeting --}}
                <div class="space-y-4 lg:col-span-3">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-white/90 backdrop-blur-sm">
                        <i class="{{ $greetingIcon }} text-[var(--accent-light)]"></i>
                        Pusat Kendali Aset Tanah
                    </span>
                    <div>
                        <h1 class="text-2xl font-bold leading-tight lg:text-[1.65rem]">{{ $greeting }}, {{ auth()->user()->name }}.</h1>
                        <p class="mt-1.5 max-w-xl text-sm leading-relaxed text-white/75">
                            Pantau data aset tanah pribadi &amp; tanah kas desa, cek status bidang, dan kelola pengguna dari satu panel.
                        </p>
                    </div>
                </div>

                {{-- Right: Primary stats --}}
                <div class="flex flex-col justify-center gap-3 lg:col-span-2">
                    <div class="group rounded-xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/[0.16] hover:shadow-lg">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/15 transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-certificate text-base text-[var(--accent-light)]"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] uppercase tracking-[0.12em] text-white/60">Total Seluruh Bidang</p>
                                <p class="text-2xl font-bold leading-tight text-white">{{ number_format($total_sertifikat) }}</p>
                            </div>
                        </div>
                        <p class="mt-2 text-xs leading-5 text-white/60">Gabungan tanah pribadi & tanah kas desa.</p>
                    </div>
                    <div class="group rounded-xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/[0.16] hover:shadow-lg">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[var(--accent)]/20 transition-transform duration-300 group-hover:scale-110">
                                <i class="fas fa-check-circle text-base text-[var(--accent-light)]"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] uppercase tracking-[0.12em] text-white/60">Aset Aktif</p>
                                <p class="text-2xl font-bold leading-tight text-white">{{ number_format($sertifikat_aktif) }}</p>
                            </div>
                        </div>
                        <p class="mt-2 text-xs leading-5 text-white/60">Data aset yang berstatus aktif siap dipantau.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════ DUAL CATEGORY STAT CARDS ══════════ --}}
        <section class="grid gap-4 lg:grid-cols-2">

            {{-- ── Tanah Pribadi ── --}}
            <div class="dash-card rounded-2xl border border-[var(--primary)]/15 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--primary)]/10">
                        <i class="fas fa-users text-sm text-[var(--primary)]"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--text)]">Tanah Milik Pribadi</h3>
                        <p class="text-[10px] text-[var(--text-muted)]">Aset tanah perseorangan warga desa</p>
                    </div>
                    <span class="ml-auto rounded-full bg-[var(--primary)]/8 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--primary)]">
                        <i class="fas fa-home mr-1"></i>Pribadi
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="rounded-xl bg-[var(--bg)] p-3 text-center">
                        <p class="text-xl font-bold text-[var(--primary)] sm:text-2xl">{{ number_format($masyarakat['total']) }}</p>
                        <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[var(--text-muted)]">Total Bidang</p>
                    </div>
                    <div class="rounded-xl bg-[var(--bg)] p-3 text-center">
                        <p class="text-xl font-bold text-[var(--primary)] sm:text-2xl">{{ number_format($masyarakat['luas'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[var(--text-muted)]">Luas (M²)</p>
                    </div>
                    <div class="rounded-xl bg-[var(--bg)] p-3 text-center">
                        <p class="text-xl font-bold text-emerald-600 sm:text-2xl">{{ number_format($masyarakat['aktif']) }}</p>
                        <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[var(--text-muted)]">Aktif</p>
                    </div>
                </div>
                <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-[var(--primary)] to-[var(--secondary)]" style="width: {{ $total_sertifikat > 0 ? round(($masyarakat['total'] / max($total_sertifikat, 1)) * 100) : 0 }}%"></div>
                </div>
                <p class="mt-1.5 text-[10px] text-[var(--text-muted)]">{{ $total_sertifikat > 0 ? round(($masyarakat['total'] / $total_sertifikat) * 100) : 0 }}% dari total aset tanah</p>
            </div>

            {{-- ── Tanah Kas Desa ── --}}
            <div class="dash-card rounded-2xl border border-[var(--accent)]/20 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--accent)]/10">
                        <i class="fas fa-landmark text-sm text-[var(--accent)]"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--text)]">Tanah Kas Desa (TKD)</h3>
                        <p class="text-[10px] text-[var(--text-muted)]">Aset milik pemerintah desa</p>
                    </div>
                    <span class="ml-auto rounded-full bg-[var(--accent)]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--accent)]">
                        <i class="fas fa-building mr-1"></i>Kas Desa
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-[var(--accent)]/5 p-3 text-center">
                        <p class="text-xl font-bold text-[var(--accent)] sm:text-2xl">{{ number_format($kasDesa['total']) }}</p>
                        <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[var(--text-muted)]">Total Bidang</p>
                    </div>
                    <div class="rounded-xl bg-[var(--accent)]/5 p-3 text-center">
                        <p class="text-xl font-bold text-[var(--accent)] sm:text-2xl">{{ number_format($kasDesa['luas'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[var(--text-muted)]">Luas (M²)</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════ SECONDARY STAT CARDS ══════════ --}}
        <section class="grid gap-4 sm:grid-cols-2">
            {{-- Card: Total Pemilik --}}
            <div class="dash-card group rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-all duration-300 hover:border-[var(--primary)]/25 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.15em] text-[var(--text-muted)]">Total Pemilik Terdaftar</p>
                        <p class="mt-1.5 text-3xl font-bold text-[var(--text)]">{{ number_format($total_pemilik) }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--secondary)]/10 text-[var(--primary)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-user-check text-lg"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-5 text-[var(--text-muted)]">Data pemilik yang terhubung dengan aset tanah desa.</p>
                <div class="mt-3 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-[var(--primary)] to-[var(--secondary)]" style="width: {{ $total_sertifikat > 0 ? min(($total_pemilik / max($total_sertifikat, 1)) * 100, 100) : 0 }}%"></div>
                </div>
            </div>

            {{-- Card: Total Pengguna --}}
            <div class="dash-card group rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-all duration-300 hover:border-[var(--accent)]/25 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-[0.15em] text-[var(--text-muted)]">Pengguna Terdaftar</p>
                        <p class="mt-1.5 text-3xl font-bold text-[var(--text)]">{{ number_format($total_pengguna) }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[var(--accent)]/10 text-[var(--accent)] transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-5 text-[var(--text-muted)]">Akun Admin & Staff yang memiliki akses ke panel.</p>
                <div class="mt-3 flex gap-1.5">
                    @for ($i = 0; $i < min($total_pengguna, 6); $i++)
                        <div class="h-1.5 flex-1 rounded-full {{ $i < $total_pengguna ? 'bg-[var(--accent)]' : 'bg-slate-100' }}"></div>
                    @endfor
                    @if($total_pengguna < 6)
                        @for ($i = $total_pengguna; $i < 6; $i++)
                            <div class="h-1.5 flex-1 rounded-full bg-slate-100"></div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        {{-- ══════════ CHARTS SECTION ══════════ --}}
        <section class="grid gap-4 lg:grid-cols-2">
            {{-- Chart: Tren Bulanan (Stacked) --}}
            <div class="dash-card rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--primary)]/10">
                            <i class="fas fa-chart-bar text-xs text-[var(--primary)]"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-[var(--text)]">Tren Input per Bulan</h3>
                            <p class="text-[10px] text-[var(--text-muted)]">6 bulan terakhir · Pribadi vs Kas Desa</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-[var(--primary)]/8 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--primary)]">
                        <i class="fas fa-arrow-trend-up mr-1"></i>Statistik
                    </span>
                </div>
                <div class="relative h-72">
                    @if(array_sum($monthlyMasyarakat) > 0 || array_sum($monthlyKasDesa) > 0)
                        <canvas id="chart-monthly" class="h-full w-full"></canvas>
                    @else
                        <div class="flex h-full flex-col items-center justify-center text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50">
                                <i class="fas fa-chart-bar text-xl text-slate-300"></i>
                            </div>
                            <p class="mt-3 text-sm font-medium text-[var(--text-muted)]">Belum ada data input</p>
                            <p class="mt-1 text-xs text-slate-400">Data akan muncul saat aset tanah mulai diinput.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Chart: Komposisi Pribadi vs Kas Desa --}}
            <div class="dash-card rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--accent)]/10">
                            <i class="fas fa-chart-pie text-xs text-[var(--accent)]"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-[var(--text)]">Komposisi Aset Tanah</h3>
                            <p class="text-[10px] text-[var(--text-muted)]">Pribadi vs Tanah Kas Desa</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-[var(--accent)]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--accent)]">
                        <i class="fas fa-layer-group mr-1"></i>Kategori
                    </span>
                </div>
                <div class="relative flex h-72 items-center justify-center">
                    @if(array_sum($komposisiData) > 0)
                        <div class="h-64 w-64">
                            <canvas id="chart-komposisi" class="h-full w-full"></canvas>
                        </div>
                    @else
                        <div class="flex h-full flex-col items-center justify-center text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50">
                                <i class="fas fa-chart-pie text-xl text-slate-300"></i>
                            </div>
                            <p class="mt-3 text-sm font-medium text-[var(--text-muted)]">Belum ada data komposisi</p>
                            <p class="mt-1 text-xs text-slate-400">Data komposisi akan muncul saat aset mulai diinput.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ══════════ DISTRIBUSI DUKUH CHART ══════════ --}}
        <section class="dash-card rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-md">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--secondary)]/10">
                        <i class="fas fa-map-marked-alt text-xs text-[var(--secondary)]"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-[var(--text)]">Distribusi per Dukuh</h3>
                        <p class="text-[10px] text-[var(--text-muted)]">Sebaran seluruh aset tanah per lokasi</p>
                    </div>
                </div>
                <span class="rounded-full bg-[var(--secondary)]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--primary)]">
                    <i class="fas fa-map-marker-alt mr-1"></i>Wilayah
                </span>
            </div>
            <div class="relative flex h-72 items-center justify-center">
                @if(count($dusunData) > 0 && array_sum($dusunData) > 0)
                    <div class="h-64 w-64">
                        <canvas id="chart-dusun"></canvas>
                    </div>
                @else
                    <div class="flex h-full flex-col items-center justify-center text-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50">
                            <i class="fas fa-map-marked-alt text-xl text-slate-300"></i>
                        </div>
                        <p class="mt-3 text-sm font-medium text-[var(--text-muted)]">Belum ada distribusi</p>
                        <p class="mt-1 text-xs text-slate-400">Data dukuh akan muncul saat aset terhubung ke lokasi.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- ══════════ TAUTAN OPERASIONAL ══════════ --}}

    </div>

    <style>
        /* Stagger entrance animation for dashboard elements */
        .dash-hero { animation: dashFadeUp 0.5s ease-out both; }
        .dash-card { animation: dashFadeUp 0.5s ease-out both; }
        .dash-card:nth-child(1) { animation-delay: 0.08s; }
        .dash-card:nth-child(2) { animation-delay: 0.16s; }
        .quick-link { animation: dashFadeUp 0.4s ease-out both; }
        .quick-link:nth-child(1) { animation-delay: 0.05s; }
        .quick-link:nth-child(2) { animation-delay: 0.10s; }
        .quick-link:nth-child(3) { animation-delay: 0.15s; }
        .quick-link:nth-child(4) { animation-delay: 0.20s; }
        .quick-link:nth-child(5) { animation-delay: 0.25s; }
        .quick-link:nth-child(6) { animation-delay: 0.30s; }

        @keyframes dashFadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Stacked Bar Chart: Tren Bulanan (Masyarakat vs Kas Desa) ──
    const ctx1 = document.getElementById('chart-monthly');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($monthlyLabels),
                datasets: [
                    {
                        label: 'Tanah Pribadi',
                        data: @json($monthlyMasyarakat),
                        backgroundColor: 'rgba(46, 125, 50, 0.7)',
                        borderColor: 'rgba(46, 125, 50, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Tanah Kas Desa',
                        data: @json($monthlyKasDesa),
                        backgroundColor: 'rgba(200, 155, 83, 0.7)',
                        borderColor: 'rgba(200, 155, 83, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 12,
                            font: { size: 11 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#6B7280',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: '600' },
                        bodyFont: { size: 11 },
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: { stepSize: 1, font: { size: 11 }, color: '#6B7280' },
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        border: { display: false },
                    },
                    x: {
                        stacked: true,
                        ticks: { font: { size: 10 }, color: '#6B7280' },
                        grid: { display: false },
                        border: { display: false },
                    }
                }
            }
        });
    }

    // ── Doughnut Chart: Komposisi Masyarakat vs Kas Desa ──
    const ctx3 = document.getElementById('chart-komposisi');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: @json($komposisiLabels),
                datasets: [{
                    data: @json($komposisiData),
                    backgroundColor: @json($komposisiColors),
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 12,
                            font: { size: 11 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#6B7280',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: '600' },
                        bodyFont: { size: 11 },
                        padding: 10,
                        cornerRadius: 8,
                    }
                }
            }
        });
    }

    // ── Doughnut Chart: Distribusi Dukuh ──
    const ctx2 = document.getElementById('chart-dusun');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: @json($dusunLabels),
                datasets: [{
                    data: @json($dusunData),
                    backgroundColor: @json($dusunColors),
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 12,
                            font: { size: 11 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#6B7280',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: '600' },
                        bodyFont: { size: 11 },
                        padding: 10,
                        cornerRadius: 8,
                    }
                }
            }
        });
    }
});
</script>
@endsection