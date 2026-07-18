@extends('admin.layout')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="mx-auto max-w-4xl">
        <x-admin.page-header title="{{ $user->name }}"
            description="Tinjau profil pengguna secara ringkas sebelum melakukan pembaruan akses.">
            <a href="{{ route('admin.pengguna.edit', $user) }}"
                class="inline-flex items-center gap-2 rounded-3xl bg-[var(--accent)] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[var(--accent-light)]">
                <i class="fas fa-edit"></i>Edit
            </a>
            <a href="{{ route('admin.pengguna.index') }}"
                class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                <i class="fas fa-arrow-left"></i>Kembali
            </a>
        </x-admin.page-header>

        <x-admin.form-card>
            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-4 first:pt-0">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Nama Lengkap</p>
                    <p class="text-base font-semibold text-[var(--text)]">{{ $user->name }}</p>
                </div>

                <div class="flex items-center justify-between py-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Email</p>
                    <p class="text-base font-semibold text-[var(--text)]">{{ $user->email }}</p>
                </div>

                <div class="flex items-center justify-between py-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Role</p>
                    <p class="text-base font-semibold text-[var(--text)]">
                        {{ $user->roles->pluck('name')->map(fn($r) => ucfirst($r))->join(', ') ?: '-' }}
                    </p>
                </div>

                <div class="flex items-center justify-between py-4">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Status</p>
                    <span
                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="flex items-center justify-between py-4 last:pb-0">
                    <p class="text-sm font-medium text-[var(--text-muted)]">Terakhir Login</p>
                    <p class="text-base font-semibold text-[var(--text)]">
                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Belum pernah' }}
                    </p>
                </div>
            </div>
        </x-admin.form-card>
    </div>
@endsection
