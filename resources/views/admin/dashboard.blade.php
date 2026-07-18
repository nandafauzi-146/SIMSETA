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
                            Pantau data aset tanah desa, cek status bidang, dan kelola pengguna dari satu panel yang konsisten.
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
                                <p class="text-[10px] uppercase tracking-[0.12em] text-white/60">Total Aset Tanah</p>
                                <p class="text-2xl font-bold leading-tight text-white">{{ number_format($total_sertifikat) }}</p>
                            </div>
                        </div>
                        <p class="mt-2 text-xs leading-5 text-white/60">Jumlah bidang tanah desa yang tercatat.</p>
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

        {{-- ══════════ STAT CARDS GRID ══════════ --}}
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
            {{-- Chart: Tren Bulanan --}}
            <div class="dash-card rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--primary)]/10">
                            <i class="fas fa-chart-bar text-xs text-[var(--primary)]"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-[var(--text)]">Tren Input per Bulan</h3>
                            <p class="text-[10px] text-[var(--text-muted)]">6 bulan terakhir</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-[var(--primary)]/8 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--primary)]">
                        <i class="fas fa-arrow-trend-up mr-1"></i>Statistik
                    </span>
                </div>
                <div class="relative h-72">
                    @if(array_sum($monthlyData) > 0)
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

            {{-- Chart: Distribusi Dusun --}}
            <div class="dash-card rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm transition-shadow duration-300 hover:shadow-md">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--accent)]/10">
                            <i class="fas fa-chart-pie text-xs text-[var(--accent)]"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-[var(--text)]">Distribusi per Dusun</h3>
                            <p class="text-[10px] text-[var(--text-muted)]">Sebaran aset per lokasi</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-[var(--accent)]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--accent)]">
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
                            <p class="mt-1 text-xs text-slate-400">Data dusun akan muncul saat aset terhubung ke lokasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ══════════ TAUTAN OPERASIONAL ══════════ --}}
        <section class="rounded-2xl border border-[var(--primary)]/10 bg-white p-5 shadow-sm lg:p-6">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--primary)]/10">
                        <i class="fas fa-bolt text-xs text-[var(--primary)]"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-[var(--text)]">Aksi Cepat</h2>
                        <p class="text-[10px] text-[var(--text-muted)]">Akses tindakan yang sering digunakan.</p>
                    </div>
                </div>
                <span class="rounded-full bg-[var(--secondary)]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[var(--primary)]">
                    <i class="fas fa-layer-group mr-1"></i>Menu
                </span>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Tambah Aset --}}
                <a href="{{ route('admin.sertifikat.create') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--primary)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--primary)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-plus text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--primary)]">Tambah Aset</p>
                        <p class="text-xs text-[var(--text-muted)]">Catat data tanah baru</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--primary)]"></i>
                </a>

                {{-- Cari Aset --}}
                <a href="{{ route('admin.sertifikat.index') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--secondary)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--secondary)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--secondary)]">Cari Aset</p>
                        <p class="text-xs text-[var(--text-muted)]">Temukan data cepat</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--secondary)]"></i>
                </a>

                {{-- Kelola Dusun --}}
                <a href="{{ route('admin.desa.index') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--primary-light)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--primary-light)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-map-marked-alt text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--primary-light)]">Kelola Dusun</p>
                        <p class="text-xs text-[var(--text-muted)]">Atur data wilayah</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--primary-light)]"></i>
                </a>

                @if(auth()->user()->hasRole('Admin'))
                {{-- Tambah Pengguna --}}
                <a href="{{ route('admin.pengguna.create') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--accent)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--accent)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-user-plus text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--accent)]">Tambah Pengguna</p>
                        <p class="text-xs text-[var(--text-muted)]">Buat akun baru</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--accent)]"></i>
                </a>

                {{-- Kelola Pengguna --}}
                <a href="{{ route('admin.pengguna.index') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--primary)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--primary)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-users-cog text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--primary)]">Kelola Pengguna</p>
                        <p class="text-xs text-[var(--text-muted)]">Atur hak akses</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--primary)]"></i>
                </a>
                @endif

                {{-- Laporan --}}
                <a href="{{ route('admin.laporan.index') }}"
                    class="quick-link group flex items-center gap-3.5 rounded-xl border border-slate-100 bg-[var(--bg)] p-4 transition-all duration-300 hover:border-[var(--primary-dark)]/25 hover:bg-white hover:shadow-md">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--primary-dark)] text-white shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:shadow-md">
                        <i class="fas fa-file-export text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-[var(--text)] transition-colors group-hover:text-[var(--primary-dark)]">Laporan</p>
                        <p class="text-xs text-[var(--text-muted)]">Unduh PDF & Excel</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-[10px] text-slate-300 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-[var(--primary-dark)]"></i>
                </a>
            </div>
        </section>

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
    // ── Bar Chart: Tren Bulanan ──
    const ctx1 = document.getElementById('chart-monthly');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Sertifikat per Bulan',
                    data: @json($monthlyData),
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx: c, chartArea} = chart;
                        if (!chartArea) return 'rgba(46, 125, 50, 0.7)';
                        const gradient = c.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(46, 125, 50, 0.5)');
                        gradient.addColorStop(1, 'rgba(102, 187, 106, 0.8)');
                        return gradient;
                    },
                    borderColor: 'rgba(46, 125, 50, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: '600' },
                        bodyFont: { size: 11 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 }, color: '#6B7280' },
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        border: { display: false },
                    },
                    x: {
                        ticks: { font: { size: 10 }, color: '#6B7280' },
                        grid: { display: false },
                        border: { display: false },
                    }
                }
            }
        });
    }

    // ── Doughnut Chart: Distribusi Dusun ──
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