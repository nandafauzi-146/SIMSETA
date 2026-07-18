<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SIMSETA</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --secondary: #66BB6A;
            --accent: #C89B53;
            --accent-light: #E8C17A;
            --bg: #F8FAFC;
            --text: #1F2937;
            --text-muted: #6B7280;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            font-size: 16px;
            line-height: 1.6;
            color: var(--text);
            background:
                radial-gradient(ellipse 90% 60% at 0% 50%, rgba(46, 125, 50, 0.04) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 100% 0%, rgba(200, 155, 83, 0.04) 0%, transparent 70%),
                var(--bg);
        }

        h1 {
            font-weight: 800;
            letter-spacing: -0.02em;
            font-size: 28px;
        }

        h2,
        h3 {
            font-weight: 700;
        }

        .brand-hero {
            background: linear-gradient(90deg, var(--primary), var(--secondary), #A5D6A7);
        }

        .brand-soft {
            background-color: rgba(46, 125, 50, 0.06);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 2px;
        }

        .sidebar-pattern::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Dorong konten ke kanan sebesar lebar sidebar, tidak bergantung Tailwind build */
        .main-content-area {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            .main-content-area {
                margin-left: 14rem; /* selebar w-56 sidebar */
            }
        }
    </style>
</head>

<body class="min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        <aside
            class="sidebar-pattern fixed inset-y-0 left-0 z-40 flex w-56 flex-col overflow-y-auto bg-gradient-to-b from-[var(--primary-dark)] via-[var(--primary)] to-[var(--primary-light)] text-white shadow-2xl shadow-black/20 md:translate-x-0 transition-transform duration-300 sidebar-scroll"
            :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

            {{-- Header --}}
            <div class="relative flex items-center justify-between gap-3 px-5 py-5">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15">
                        <i class="fas fa-landmark text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight tracking-tight">SIMSETA</h1>
                        <p class="text-[11px] text-white/70">Panel Admin & Staff</p>
                    </div>
                </div>
                <button class="md:hidden p-2 rounded-lg bg-black/20 hover:bg-black/30" @click="sidebarOpen = false">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            {{-- User card --}}
            <div class="relative px-4 pb-4">
                <div class="flex items-center gap-3 rounded-2xl bg-white/10 p-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/20 text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <h2 class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</h2>
                        <p class="text-xs text-white/65">{{ auth()->user()->getRoleNames()->first() ?: 'Staff' }}</p>
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="relative flex-1 space-y-4 overflow-y-auto px-3 pb-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fas fa-chart-line w-4 text-center text-sm"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.sertifikat.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.sertifikat.*') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fas fa-landmark w-4 text-center text-sm"></i>
                    Kelola Aset Tanah
                </a>
                <a href="{{ route('admin.desa.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.desa.*') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fas fa-map-marked-alt w-4 text-center text-sm"></i>
                    Dusun
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.laporan.*') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fas fa-file-export w-4 text-center text-sm"></i>
                    Laporan
                </a>
                @if(auth()->user()->hasRole('Admin'))
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.pengguna.*') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-users w-4 text-center text-sm"></i>
                        Pengguna
                    </a>
                @endif

                <p class="px-3.5 pb-1 pt-4 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Lainnya</p>
                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-white/20 text-white shadow-md' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fas fa-cog w-4 text-center text-sm"></i>
                    Pengaturan
                </a>
            </nav>

            {{-- Footer --}}
            <div class="relative mt-auto border-t border-white/10 p-3">
                <button type="button" onclick="window.showLogoutModal = true; document.getElementById('logout-modal').classList.remove('hidden')"
                    class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-left text-sm font-semibold text-white/90 transition hover:bg-white/10">
                    <i class="fas fa-sign-out-alt w-4 text-center text-sm"></i>Keluar
                </button>
                <p class="mt-2 px-3.5 text-[10px] text-white/40">SIMSETA &copy; {{ date('Y') }} &middot; Tegalmulyo</p>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 z-30 bg-black/50 md:hidden transition-opacity"></div>

        <div class="flex-1 main-content-area">
            <div class="sticky top-0 z-20 border-b border-[#2E7D32]/15 bg-white/90 backdrop-blur-md">
                <div class="flex flex-wrap items-center justify-between gap-x-9 gap-y-5 p-4">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true"
                            class="md:hidden rounded-xl border border-[#2E7D32]/20 bg-white p-2 text-[#1F2937] shadow-sm hover:border-[#2E7D32]">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h1 class="text-xl font-semibold text-[#1F2937]">@yield('page-heading', 'Dashboard')</h1>
                            <p class="text-sm text-[var(--text-muted)]">Panel manajemen untuk Admin dan Staff.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-[var(--text)]">
                        <span class="hidden sm:inline font-semibold text-sm text-[#1F2937]">{{ now()->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <main class="min-h-[calc(100vh-80px)] px-4 py-6 sm:px-6 lg:px-8">
                @if ($message = session('success'))
                    <div class="mb-4 rounded-3xl border border-[#66BB6A]/30 bg-[#66BB6A]/10 px-5 py-4 text-[#1F2937] shadow-sm"
                        x-data="{ show: true }" x-show="show" @click.away="show = false">
                        {{ $message }}
                    </div>
                @endif

                @if ($message = session('error'))
                    <div class="mb-4 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm"
                        x-data="{ show: true }" x-show="show" @click.away="show = false">
                        {{ $message }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Logout Modal --}}
    <div id="logout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        onclick="if(event.target===this) document.getElementById('logout-modal').classList.add('hidden')">
        <div class="mx-4 w-full max-w-xs animate-modal rounded-xl bg-white p-5 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 mb-3">
                    <i class="fas fa-sign-out-alt text-sm text-red-500"></i>
                </div>
                <h3 class="text-sm font-bold text-[var(--text)]">Yakin ingin keluar?</h3>
                <p class="mt-0.5 text-xs text-[var(--text-muted)]">Anda akan keluar dari panel admin SIMSETA.</p>
            </div>
            <div class="mt-4 flex gap-2">
                <button type="button" onclick="document.getElementById('logout-modal').classList.add('hidden')"
                    class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[var(--text)] transition hover:bg-slate-50">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                        <i class="fas fa-sign-out-alt mr-1.5"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .animate-modal {
            animation: modalIn 0.2s ease-out;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

    @yield('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>