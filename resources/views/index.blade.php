<!DOCTYPE html>
<html lang="id" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ── Primary SEO ─────────────────────────────────────── --}}
    <title>SIMSETA — Cek Sertifikat Tanah Desa Tegalmulyo Online</title>
    <meta name="description" content="Portal publik resmi Pemerintah Desa Tegalmulyo untuk pengecekan status sertifikat tanah. Cari data aset tanah berdasarkan nomor sertifikat atau alas hak kepemilikan secara cepat dan aman.">
    <meta name="keywords" content="sertifikat tanah, cek sertifikat tanah, tegalmulyo, alas hak, NIB, aset desa, pertanahan, desa tegalmulyo, klaten">
    <meta name="author" content="Pemerintah Desa Tegalmulyo">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ url('/') }}">

    {{-- ── Open Graph (Facebook, WhatsApp, LinkedIn) ──────── --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="SIMSETA — Cek Sertifikat Tanah Desa Tegalmulyo">
    <meta property="og:description" content="Portal publik resmi untuk pengecekan status sertifikat tanah. Cari data aset tanah berdasarkan nomor sertifikat atau alas hak kepemilikan secara cepat dan aman.">
    <meta property="og:image" content="{{ asset('Logo-Simseta.webp') }}">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="Logo SIMSETA Desa Tegalmulyo">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="SIMSETA Tegalmulyo">

    {{-- ── Twitter Card ─────────────────────────────────────── --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SIMSETA — Cek Sertifikat Tanah Desa Tegalmulyo">
    <meta name="twitter:description" content="Portal publik resmi untuk pengecekan status sertifikat tanah berdasarkan nomor sertifikat atau alas hak kepemilikan.">
    <meta name="twitter:image" content="{{ asset('Logo-Simseta.webp') }}">
    <meta name="twitter:image:alt" content="Logo SIMSETA">

    {{-- ── Geo & Local SEO ─────────────────────────────────── --}}
    <meta name="geo.region" content="ID-JT">
    <meta name="geo.placename" content="Desa Tegalmulyo, Kemalang, Klaten, Jawa Tengah">
    <meta name="geo.position" content="-7.5676;110.4572">
    <meta name="ICBM" content="-7.5676, 110.4572">

    {{-- ── Favicon ──────────────────────────────────────────── --}}
    <link rel="icon" type="image/webp" href="{{ asset('Logo-Simseta.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('Logo-Simseta.webp') }}">

    {{-- ── Preconnect & Fonts ───────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    {{-- ── JSON-LD Structured Data ─────────────────────────── --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "GovernmentService",
      "name": "SIMSETA — Sistem Informasi Manajemen Sertifikat Tanah",
      "description": "Portal publik resmi Pemerintah Desa Tegalmulyo untuk pengecekan status sertifikat tanah dan aset pertanahan desa.",
      "url": "{{ url('/') }}",
      "provider": {
        "@type": "GovernmentOrganization",
        "name": "Pemerintah Desa Tegalmulyo",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Tegalmulyo",
          "addressRegion": "Jawa Tengah",
          "addressCountry": "ID"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": "-7.5676",
          "longitude": "110.4572"
        },
        "openingHoursSpecification": {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "08:00",
          "closes": "15:00"
        }
      },
      "serviceType": "Layanan Informasi Pertanahan",
      "areaServed": {
        "@type": "Place",
        "name": "Desa Tegalmulyo, Kemalang, Klaten"
      }
    }
    </script>

    {{-- ── FAQ Structured Data ──────────────────────────────── --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        { "@type": "Question", "name": "Apa itu SIMSETA?", "acceptedAnswer": { "@type": "Answer", "text": "SIMSETA adalah portal publik layanan informasi pertanahan resmi Pemerintah Desa Tegal Mulyo berupa pusat data digital untuk transparansi dan kemudahan akses status sertifikat tanah secara mandiri." } },
        { "@type": "Question", "name": "Apakah informasi yang ditampilkan resmi?", "acceptedAnswer": { "@type": "Answer", "text": "Data berasal dari administrasi Pemerintah Desa Tegal Mulyo dan digunakan sebagai media informasi masyarakat." } },
        { "@type": "Question", "name": "Mengapa data saya tidak ditemukan?", "acceptedAnswer": { "@type": "Answer", "text": "Pastikan nomor yang dimasukkan benar. Jika tetap tidak ditemukan, silakan menghubungi kantor desa pada jam pelayanan." } },
        { "@type": "Question", "name": "Apa itu Alas Hak / Bukti Kepemilikan?", "acceptedAnswer": { "@type": "Answer", "text": "Alas hak adalah dokumen dasar kepemilikan tanah seperti nomor sertifikat, girik, atau akta jual beli yang tercatat di administrasi desa." } }
      ]
    }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --navy: #1E3A5F;
            --primary: #2E7D32;
            --primary-dark: #1B5E20;
            --primary-light: #4CAF50;
            --accent: #C89B53;
            --bg: #F8FAFC;
            --text: #1F2937;
            --text-muted: #6B7280;
        }
        *, *::before, *::after { box-sizing: border-box; }
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            color: var(--text);
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232e7d32' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .navbar {
            position: fixed; top: 16px; left: 50%; transform: translateX(-50%);
            z-index: 50; width: calc(100% - 32px); max-width: 72rem;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(16px);
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
            border-radius: 1rem;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .hero-title {
            font-size: clamp(2rem, 5vw, 3.25rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.15;
        }
        .search-card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: 0 8px 40px rgba(30,58,95,0.10), 0 2px 8px rgba(30,58,95,0.06);
            border-radius: 1.25rem;
            padding: 2rem;
        }
        @media (max-width: 640px) {
            .search-card { padding: 1.25rem; }
            .step-card-mobile { padding: 1.25rem !important; }
            .help-card-mobile { padding: 1.5rem !important; }
            .section-mobile { padding-top: 3rem !important; padding-bottom: 3rem !important; }
            .hero-pb-mobile { padding-bottom: 2.5rem !important; }
            .sponsor-icon { width: 40px !important; height: 40px !important; }
            .sponsor-badge { padding: 0.625rem 1rem !important; gap: 0.625rem !important; }
            .sponsor-text { font-size: 0.875rem !important; }
            .sponsor-title { font-size: 0.75rem !important; }
        }
        .step-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
        }
        .faq-item { border-radius: 0.875rem; overflow: hidden; }
        .faq-item details, .faq-item summary { display: block; }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-trigger { width: 100%; text-align: left; cursor: pointer; background: none; border: none; font-family: inherit; }
        details.faq-item[open] .faq-trigger { border-bottom: 1px solid #f3f4f6; }
        details.faq-item[open] .chevron { transform: rotate(180deg); }
        .section-divider {
            width: 3.5rem; height: 4px; margin: 0 auto 1.5rem auto; border-radius: 999px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }
        .sponsor-badge {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.875rem;
            padding: 1.25rem;
            border-radius: 1rem;
            background: white;
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            transition: box-shadow 0.25s, border-color 0.25s;
            text-align: center;
        }
        .sponsor-badge:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.10); border-color: #CBD5E1; }
        .sponsor-icon { filter: grayscale(1); transition: filter 0.3s; }
        .sponsor-badge:hover .sponsor-icon { filter: none; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeUp 0.6s ease-out 0.05s both; }
        .anim-2 { animation: fadeUp 0.6s ease-out 0.15s both; }
        .anim-3 { animation: fadeUp 0.6s ease-out 0.25s both; }
        .anim-4 { animation: fadeUp 0.6s ease-out 0.35s both; }
        .anim-5 { animation: fadeUp 0.6s ease-out 0.45s both; }
        .anim-6 { animation: fadeUp 0.6s ease-out 0.55s both; }
    </style>
</head>
<body class="antialiased hero-pattern">

    <header class="navbar" role="banner" aria-label="Navigasi utama SIMSETA">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2" aria-label="SIMSETA Beranda">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#2E7D32,#66BB6A);">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" viewBox="0 0 20 20" fill="white" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold" style="color:var(--navy);">SIMSETA</span>
                    </a>
                </div>
                <a href="/login"
                   class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-semibold text-white transition hover:opacity-90 hover:-translate-y-0.5"
                   style="background:linear-gradient(135deg,var(--primary),var(--primary-light));box-shadow:0 2px 8px rgba(46,125,50,0.25);"
                   aria-label="Login ke panel admin">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Login
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center" role="main" id="main-content" aria-label="Konten utama SIMSETA">

        <section class="w-full flex flex-col items-center px-4 sm:px-6 pt-36 sm:pt-40 pb-16 hero-pb-mobile">
            <div class="text-center max-w-2xl mx-auto anim-1">
                <h1 class="hero-title mb-4" style="color:var(--navy);">
                    Layanan Informasi<br>
                    <span style="color:var(--primary);">Sertifikat Tanah</span><br>
                    <span style="color:var(--primary);">Desa Tegalmulyo</span>
                </h1>
                <p class="text-base leading-relaxed" style="color:var(--text-muted);">
                    Pusat data digital untuk transparansi dan kemudahan akses<br class="hidden sm:block">
                    status sertifikat tanah secara mandiri.
                </p>
            </div>

            <div class="w-full max-w-2xl mx-auto mt-10 anim-2">
                @include('partials.pencarian-publik')
            </div>
        </section>

        {{-- Cara Menggunakan --}}
        <section class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-16 section-mobile anim-3">
            <div class="text-center mb-10">
                <div class="section-divider"></div>
                <h2 class="text-2xl sm:text-3xl font-bold" style="color:var(--navy);">Cara Menggunakan SIMSETA</h2>
                <p class="mt-2 text-sm" style="color:var(--text-muted);">Cukup tiga langkah sederhana untuk mengetahui status sertifikat tanah.</p>
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <div class="bg-white rounded-2xl p-6 step-card-mobile border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="step-icon mx-auto mb-4" style="background:rgba(46,125,50,0.08);">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:26px;height:26px;color:var(--primary);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 11 12 6 7 11"/><line x1="12" y1="18" x2="12" y2="6"/></svg>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--primary);">Langkah 1</div>
                    <h3 class="text-base font-semibold mb-2" style="color:var(--navy);">Masukkan Nomor</h3>
                    <p class="text-sm leading-relaxed" style="color:var(--text-muted);">Ketik nomor sertifikat atau alas hak kepemilikan pada kolom pencarian.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 step-card-mobile border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="step-icon mx-auto mb-4" style="background:rgba(30,58,95,0.06);">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:26px;height:26px;color:var(--navy);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--navy);">Langkah 2</div>
                    <h3 class="text-base font-semibold mb-2" style="color:var(--navy);">Sistem Memverifikasi</h3>
                    <p class="text-sm leading-relaxed" style="color:var(--text-muted);">Data akan dicek secara otomatis berdasarkan data administrasi desa.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 step-card-mobile border border-gray-100 shadow-sm text-center hover:shadow-md transition-shadow">
                    <div class="step-icon mx-auto mb-4" style="background:rgba(200,155,83,0.10);">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:26px;height:26px;color:var(--accent);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--accent);">Langkah 3</div>
                    <h3 class="text-base font-semibold mb-2" style="color:var(--navy);">Lihat Hasil</h3>
                    <p class="text-sm leading-relaxed" style="color:var(--text-muted);">Informasi status sertifikat langsung ditampilkan secara cepat dan aman.</p>
                </div>
            </div>
        </section>

        {{-- FAQ --}}
        <section class="w-full max-w-2xl mx-auto px-4 sm:px-6 py-16 section-mobile anim-4">
            <div class="text-center mb-8">
                <div class="section-divider"></div>
                <h2 class="text-2xl sm:text-3xl font-bold" style="color:var(--navy);">Pertanyaan Umum</h2>
            </div>
            <div class="space-y-3">
                @php
                    $faqs = [
                        ['q' => 'Apa Itu SIMSETA?', 'a' => 'SIMSETA (Sistem Informasi Manajemen Sertifikat Tanah) adalah portal publik layanan informasi pertanahan resmi Pemerintah Desa Tegal Mulyo berupa pusat data digital untuk transparansi dan kemudahan akses status sertifikat tanah secara mandiri.'],
                        ['q' => 'Apakah informasi yang ditampilkan resmi?', 'a' => 'Data berasal dari administrasi Pemerintah Desa Tegal Mulyo dan digunakan sebagai media informasi masyarakat.'],
                        ['q' => 'Mengapa data saya tidak ditemukan?', 'a' => 'Pastikan nomor yang dimasukkan benar. Jika tetap tidak ditemukan, silakan menghubungi kantor desa pada jam pelayanan.'],
                        ['q' => 'Apakah data dapat diubah secara online?', 'a' => 'Tidak. Perubahan data hanya dapat dilakukan melalui prosedur administrasi resmi di Pemerintahan Desa.'],
                        ['q' => 'Apa itu Alas Hak / Bukti Kepemilikan?', 'a' => 'Alas hak adalah dokumen dasar kepemilikan tanah seperti nomor sertifikat, girik, atau akta jual beli yang tercatat di administrasi desa.'],
                    ];
                @endphp
                @foreach($faqs as $faq)
                <details name="faq" class="faq-item bg-white border border-gray-100 shadow-sm group">
                    <summary class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left list-none cursor-pointer">
                        <span class="text-sm font-semibold flex items-center gap-2" style="color:var(--navy);">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;flex-shrink:0;color:var(--primary);" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $faq['q'] }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;flex-shrink:0;transition:transform 0.25s;color:var(--text-muted);" class="chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </summary>
                    <p class="px-5 pb-5 text-sm leading-relaxed border-t border-gray-50 pt-3" style="color:var(--text-muted);">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </section>

        {{-- Sponsor --}}
        <section class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-16 section-mobile anim-5">
            <div class="section-divider"></div>
            <p class="text-center text-lg sponsor-title font-bold uppercase tracking-[0.2em] mb-8" style="color:var(--text-muted);">Disponsori &amp; Didukung Oleh</p>
            <div class="flex flex-wrap justify-center items-center gap-4">
                <div class="sponsor-badge">
                    <div class="sponsor-icon w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm border border-gray-100 flex-shrink-0">
                        <img src="{{ asset('hmsi-logo.webp') }}" alt="HMSI UTY" class="w-full h-full object-contain p-0.5">
                    </div>
                    <span class="text-lg sponsor-text font-bold" style="color:var(--navy);">HMSI <span class="font-normal" style="color:var(--text-muted);">UTY</span></span>
                </div>
                <div class="sponsor-badge">
                    <div class="sponsor-icon w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background:linear-gradient(135deg,#22c55e,#059669);">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-lg sponsor-text font-bold" style="color:var(--navy);">Pemdes <span class="font-normal" style="color:var(--text-muted);">Tegalmulyo</span></span>
                </div>
                <div class="sponsor-badge">
                    <div class="sponsor-icon w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm border border-gray-100 flex-shrink-0 overflow-hidden">
                        <img src="{{ asset('Logo-Hmsi Impact.webp') }}" alt="HMSI IMPACT" class="w-full h-full object-contain p-0.5">
                    </div>
                    <span class="text-lg sponsor-text font-bold" style="color:var(--navy);">HMSI <span class="font-normal" style="color:var(--text-muted);">IMPACT</span></span>
                </div>
            </div>
        </section>

        {{-- Butuh Bantuan --}}
        <section class="w-full max-w-3xl mx-auto px-4 sm:px-6 pt-2 pb-20 anim-6">
            <div class="rounded-2xl p-7 sm:p-8 help-card-mobile text-white" style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));">
                <h3 class="text-xl font-bold mb-1.5">Butuh Bantuan?</h3>
                <p class="text-sm leading-relaxed text-white/80 mb-7">Apabila data sertifikat tidak ditemukan atau terdapat kesalahan informasi, silakan menghubungi Pemerintah Desa Tegal Mulyo.</p>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="flex flex-col gap-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-1.5">Jam Pelayanan</p>
                            <p class="text-sm font-medium">Senin – Jumat</p>
                            <p class="text-sm text-white/80">08.00 – 15.00 WIB</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-1.5">Kontak</p>
                            <p class="text-sm font-medium">(0272) XXXXXXXX</p>
                            <p class="text-sm text-white/80">pemdes@tegalmulyo.id</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-white/60 mb-1.5">Kantor Desa</p>
                        <p class="text-sm font-medium">Desa Tegal Mulyo, Kecamatan</p>
                        <p class="text-sm text-white/80">Kemalang, Kabupaten Klaten</p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31640.53597388172!2d110.45729784662113!3d-7.567675049680587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a66508a1a0b87%3A0x9fe11b958b83a15d!2sBalai%20Desa%20Tegalmulyo!5e0!3m2!1sid!2sid!4v1784348700323!5m2!1sid!2sid" width="100%" height="200" style="border:0; border-radius: 0.5rem; margin-top: 1rem;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="border-t border-gray-200 bg-white mt-auto" role="contentinfo">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs" style="color:var(--text-muted);">
                <span>&copy; {{ date('Y') }} Sistem Informasi Manajemen Sertifikat Tanah (SIMSETA) &mdash; Pemerintah Desa Tegalmulyo.</span>
                <nav aria-label="Tautan kaki halaman" class="flex gap-4">
                    <a href="/sitemap.xml" class="hover:underline" aria-label="Sitemap XML">Sitemap</a>
                    <a href="/robots.txt" class="hover:underline" aria-label="Robots.txt">Robots</a>
                </nav>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</body>
</html>