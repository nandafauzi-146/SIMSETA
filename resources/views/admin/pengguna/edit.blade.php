@extends('admin.layout')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="mx-auto max-w-5xl">
        <x-admin.page-header title="Edit Pengguna"
            description="Perbarui data akun dan akses pengguna sesuai kebutuhan tim." />

        <x-admin.form-card>
            <form method="POST" action="{{ route('admin.pengguna.update', $user) }}" class="space-y-6">
                @csrf @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nama *</label>
                        <input type="text" name="name" required
                            placeholder="Masukkan nama lengkap"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('name') border-red-500 @enderror"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Email *</label>
                        <input type="email" name="email" required
                            placeholder="contoh@email.com"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('email') border-red-500 @enderror"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Password Baru</label>
                        <input type="password" name="password"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            placeholder="Ulangi password baru"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Role *</label>
                        <select name="role" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('role') border-red-500 @enderror">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-8">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-300 text-[var(--primary)] focus:ring-[var(--primary)]">
                        <label for="is_active" class="text-sm font-semibold text-[var(--text)]">Akun aktif</label>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                        <i class="fas fa-save"></i>Perbarui
                    </button>
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </x-admin.form-card>
    </div>
@endsection
