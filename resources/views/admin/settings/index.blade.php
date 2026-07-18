@extends('admin.layout')

@section('title', 'Pengaturan')

@section('content')
<div class="mx-auto max-w-3xl">
    <x-admin.page-header title="Pengaturan Identitas Desa"
        description="Atur informasi identitas desa yang akan tampil di laporan dan halaman publik." />

    <x-admin.form-card>
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nama Desa *</label>
                    <input type="text" name="nama_desa" required
                        value="{{ old('nama_desa', $desa->nama ?? 'Tegalmulyo') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Dusun</label>
                    <input type="text" name="dusun"
                        value="{{ old('dusun', $desa->dusun ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Kecamatan</label>
                    <input type="text" name="kecamatan"
                        value="{{ old('kecamatan', \App\Models\Setting::where('key', 'kecamatan')->value('value') ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Kabupaten</label>
                    <input type="text" name="kabupaten"
                        value="{{ old('kabupaten', \App\Models\Setting::where('key', 'kabupaten')->value('value') ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Provinsi</label>
                    <input type="text" name="provinsi"
                        value="{{ old('provinsi', \App\Models\Setting::where('key', 'provinsi')->value('value') ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Telepon</label>
                    <input type="text" name="telepon"
                        value="{{ old('telepon', \App\Models\Setting::where('key', 'telepon')->value('value') ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', \App\Models\Setting::where('key', 'email')->value('value') ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Alamat Kantor</label>
                    <textarea name="alamat_kantor" rows="3"
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm">{{ old('alamat_kantor', \App\Models\Setting::where('key', 'alamat_kantor')->value('value') ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 pt-6 mt-6">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-[var(--primary-dark)] transition">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </form>
    </x-admin.form-card>
</div>
@endsection
