<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMSETA Tegal Mulyo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary:        #2E7D32;
            --primary-dark:   #1B5E20;
            --primary-light:  #4CAF50;
            --secondary:      #66BB6A;
            --accent:         #C89B53;
            --accent-light:   #E8C17A;
            --bg:             #F8FAFC;
            --text:           #1F2937;
            --text-muted:     #6B7280;
            --danger:         #DC2626;
            --danger-bg:      #FEF2F2;
            --danger-border:  #FECACA;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Full-page background ─────────────────────────────────── */
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
        }

        /* Geometric tile overlay */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M40 46v-6h-2v6h-6v2h6v6h2v-6h6v-2h-6zm0-40V0h-2v6h-6v2h6v6h2V8h6V6h-6zM8 46v-6H6v6H0v2h6v6h2v-6h6v-2H8zM8 6V0H6v6H0v2h6v6h2V8h6V6H8z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Decorative blobs */
        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            pointer-events: none;
        }

        .blob-bottom {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,0,0,0.12) 0%, transparent 70%);
            bottom: -150px;
            left: -100px;
            pointer-events: none;
        }

        /* ── Card ─────────────────────────────────────────────────── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 20px;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.15),
                0 25px 60px rgba(0,0,0,0.25),
                0 8px 24px rgba(0,0,0,0.12);
            overflow: hidden;
            animation: cardIn 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        /* Accent top stripe */
        .card-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--primary-dark), var(--secondary), var(--accent));
        }

        .card-body { padding: 2.5rem; }

        /* ── Card Header ──────────────────────────────────────────── */
        .card-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .logo-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(46,125,50,0.35);
        }

        .card-title-block { text-align: center; margin-bottom: 2rem; }

        .card-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: rgba(46,125,50,0.08);
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            margin-bottom: 0.875rem;
        }

        .card-heading {
            font-size: 1.625rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .card-subheading {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            line-height: 1.65;
        }

        /* ── Error Alert ──────────────────────────────────────────── */
        .alert-error {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            border-radius: 10px;
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-icon { flex-shrink: 0; color: var(--danger); }

        .alert-error li {
            list-style: none;
            font-size: 0.8125rem;
            color: var(--danger);
            line-height: 1.6;
        }

        /* ── Form Fields ──────────────────────────────────────────── */
        .field { margin-bottom: 1.125rem; }

        .field-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.45rem;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 0.9375rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-family: inherit;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .field-input::placeholder { color: #CBD5E1; }

        .field-input:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3.5px rgba(46,125,50,0.12);
        }

        .field-input:focus ~ .field-icon { color: var(--primary); }

        .field-input.is-error {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
        }

        .field-toggle {
            position: absolute;
            right: 0.9375rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            display: flex;
            align-items: center;
            padding: 2px;
            border-radius: 4px;
            transition: color 0.2s;
        }

        .field-toggle:hover { color: var(--primary); }

        /* ── Remember Row ─────────────────────────────────────────── */
        .form-options {
            display: flex;
            align-items: center;
            margin-top: 0.25rem;
            margin-bottom: 1.625rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .remember-checkbox {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember-text {
            font-size: 0.8125rem;
            color: var(--text-muted);
            user-select: none;
        }

        /* ── Submit Button ────────────────────────────────────────── */
        .btn-login {
            width: 100%;
            padding: 0.9rem 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            font-family: inherit;
            font-size: 0.9375rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(46,125,50,0.38);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.13) 0%, transparent 100%);
            pointer-events: none;
        }

        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(46,125,50,0.44);
        }

        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { cursor: not-allowed; opacity: 0.65; transform: none; }

        .btn-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* ── Divider + Footer ─────────────────────────────────────── */
        .card-footer {
            margin-top: 1.75rem;
            padding-top: 1.375rem;
            border-top: 1px solid #F1F5F9;
            text-align: center;
        }

        .card-footer p {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.65;
        }

        .card-footer strong { color: var(--primary); font-weight: 600; }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            color: var(--primary);
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 0.875rem;
            transition: opacity 0.2s;
        }

        .back-link:hover { opacity: 0.7; }

        /* ── Animations ───────────────────────────────────────────── */
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>

<body>
    <div class="blob-bottom"></div>

    {{-- Centered Login Card --}}
    <div style="display:flex;flex-direction:column;align-items:center;position:relative;z-index:10;width:100%;">
        <div class="login-card">
            <div class="card-stripe"></div>

            <div class="card-body">
                {{-- Logo Icon --}}
                <div class="card-logo">
                    <div class="logo-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <div class="card-title-block">
                    <div class="card-eyebrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        SIMSETA
                    </div>
                    <h1 class="card-heading">Selamat Datang</h1>
                    <p class="card-subheading">Sistem Informasi Manajemen Sertifikat Tanah</p>
                </div>

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="alert-error" role="alert">
                        <svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    id="login-form"
                    x-data="{ showPass: false, loading: false }"
                    @submit="loading = true"
                >
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label for="email" class="field-label">Alamat Email</label>
                        <div class="field-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="Email"
                                class="field-input {{ $errors->has('email') ? 'is-error' : '' }}"
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="password" class="field-label">Password</label>
                        <div class="field-wrap">
                            <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input
                                :type="showPass ? 'text' : 'password'"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                style="padding-right: 3rem;"
                            >
                            <button type="button" class="field-toggle" @click="showPass = !showPass" tabindex="-1" aria-label="Tampilkan/Sembunyikan password">
                                <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPass" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="form-options">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember" class="remember-checkbox">
                            <span class="remember-text">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    {{-- Turnstile --}}
                    <div class="cf-turnstile mb-4" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>

                    {{-- Submit --}}
                    <button type="submit" id="btn-login" class="btn-login" :disabled="loading">
                        <span class="btn-inner">
                            <template x-if="!loading">
                                <span style="display:flex;align-items:center;gap:0.5rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                                    </svg>
                                    Masuk
                                </span>
                            </template>
                            <template x-if="loading">
                                <span style="display:flex;align-items:center;gap:0.5rem;">
                                    <svg style="animation:spin 0.8s linear infinite;width:16px;height:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
                                        <path style="opacity:0.85" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    Memproses...
                                </span>
                            </template>
                        </span>
                    </button>
                </form>

                {{-- Card Footer --}}
                <div class="card-footer">
                    <p>Sistem ini di Kelola oleh Pemerintah Desa<strong>Tegal Mulyo</strong> Untuk Pengelolaan Data </p>
                    <a href="/" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
