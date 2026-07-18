@extends('admin.layout')

@section('title', 'Tambah Desa')

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-admin.page-header title="Tambah Desa Baru"
            description="Tambahkan desa untuk digunakan pada data aset tanah." />

        <x-admin.form-card>
            <form method="POST" action="{{ route('admin.desa.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nama Desa</label>
                    <input type="text" value="Tegalmulyo" disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-[var(--text-muted)] cursor-not-allowed">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Dusun *</label>
                    <input type="text" name="dusun" required
                        placeholder="Masukkan nama dusun"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('dusun') border-red-500 @enderror"
                        value="{{ old('dusun') }}">
                    @error('dusun')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                    <a href="{{ route('admin.desa.index') }}"
                        class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </x-admin.form-card>
    </div>
@endsection
