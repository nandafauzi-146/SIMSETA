@extends('admin.layout')

@section('title', 'Edit Data Tanah')

@push('styles')
<style>[x-cloak]{display:none!important}</style>
@endpush

@section('content')
<div class="mx-auto max-w-5xl"
    x-data="{
        kategori: '{{ old('kategori', $sertifikat->kategori) }}',
        statusTanah: '{{ old('status_nama', $sertifikat->status->nama ?? 'Aktif') }}'
    }">

    <x-admin.page-header title="Edit Data Tanah"
        description="Perbarui informasi data tanah di bawah ini agar selalu akurat." />

    <x-admin.form-card>
        <form method="POST" action="{{ route('admin.sertifikat.update', $sertifikat) }}" class="space-y-8">
            @csrf @method('PUT')

            {{-- ─── Error Global ─── --}}
            @if($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                <p class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-1.5"></i>Harap perbaiki kesalahan berikut:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- ════════ A. INFORMASI TANAH ════════ --}}
            <div>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[var(--primary)] border-b border-slate-100 pb-2">A. Informasi Tanah</h3>
                
                {{-- Kategori --}}
                <div class="mb-5">
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Kategori Tanah <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-4">
                        <label :class="kategori==='masyarakat' ? 'border-[var(--primary)] bg-[var(--primary)]/5 ring-2 ring-[var(--primary)]/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                            class="flex items-center gap-3 cursor-pointer px-5 py-3.5 rounded-xl border shadow-sm transition-all flex-1 min-w-[250px]">
                            <input type="radio" name="kategori" value="masyarakat" x-model="kategori" class="text-[var(--primary)] focus:ring-[var(--primary)]">
                            <div>
                                <span class="block text-sm font-semibold text-[var(--text)]">Tanah Pribadi</span>
                                <span class="block text-xs text-[var(--text-muted)]">Aset tanah milik perseorangan / warga</span>
                            </div>
                        </label>
                        <label :class="kategori==='kas_desa' ? 'border-[var(--accent)] bg-[var(--accent)]/5 ring-2 ring-[var(--accent)]/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                            class="flex items-center gap-3 cursor-pointer px-5 py-3.5 rounded-xl border shadow-sm transition-all flex-1 min-w-[250px]">
                            <input type="radio" name="kategori" value="kas_desa" x-model="kategori" class="text-[var(--accent)] focus:ring-[var(--accent)]">
                            <div>
                                <span class="block text-sm font-semibold text-[var(--text)]">Tanah Kas Desa (TKD)</span>
                                <span class="block text-xs text-[var(--text-muted)]">Aset milik instansi/pemerintah desa</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nomor Sertifikat / Alas Hak <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_sertifikat" required placeholder="Contoh: M.1234 atau HP.567"
                            value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('nomor_sertifikat') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">NIB (Nomor Identifikasi Bidang) (Opsional)</label>
                        <input type="text" name="nib" placeholder="Contoh: 12.01.02.03.04567"
                            value="{{ old('nib', $sertifikat->nib) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('nib') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Jenis Hak <span class="text-red-500">*</span></label>
                        <input type="text" name="jenis_hak_nama" required placeholder="Contoh: Hak Milik, Hak Pakai, Letter C"
                            value="{{ old('jenis_hak_nama', $sertifikat->jenis_hak->nama ?? '') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('jenis_hak_nama') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Luas Tanah (m²) <span class="text-red-500">*</span></label>
                        <input type="number" name="luas" required step="0.01" min="0" placeholder="0.00"
                            value="{{ old('luas', (float)$sertifikat->luas) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('luas') border-red-500 @enderror">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Status Tanah <span class="text-red-500">*</span></label>
                        <input type="text" name="status_nama" required x-model="statusTanah" placeholder="Contoh: Aktif, Disewakan, Digarap, Sengketa, Arsip"
                            value="{{ old('status_nama', $sertifikat->status->nama ?? 'Aktif') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('status_nama') border-red-500 @enderror">
                    </div>
                </div>
            </div>

            {{-- ════════ B. DATA PEMILIK / PENGELOLA ════════ --}}
            <div>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[var(--primary)] border-b border-slate-100 pb-2">
                    B. Data <span x-text="kategori === 'masyarakat' ? 'Pemilik (Pribadi)' : 'Pengelola (Kas Desa)'"></span>
                </h3>

                {{-- Form Milik Warga --}}
                <div x-show="kategori === 'masyarakat'" x-transition class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">NIK Pemilik</label>
                        <input type="text" name="nik" placeholder="16 digit NIK" maxlength="16"
                            value="{{ old('nik', $sertifikat->pemilik->nik ?? '') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nama Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="pemilik_nama" :required="kategori === 'masyarakat'" placeholder="Nama lengkap sesuai KTP"
                            value="{{ old('pemilik_nama', $sertifikat->kategori === 'masyarakat' ? ($sertifikat->pemilik->nama ?? '') : '') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Alamat Pemilik</label>
                        <textarea name="alamat_pemilik" rows="2" placeholder="Alamat domisili pemilik saat ini..."
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">{{ old('alamat_pemilik', $sertifikat->pemilik->alamat ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Form Kas Desa --}}
                <div x-show="kategori === 'kas_desa'" x-cloak x-transition class="grid gap-5 md:grid-cols-2 rounded-2xl border border-amber-200 bg-amber-50/30 p-5">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Penanggung Jawab <span class="text-red-500">*</span></label>
                        <input type="text" name="penanggung_jawab" :required="kategori === 'kas_desa'" placeholder="Contoh: Budi Santoso"
                            value="{{ old('penanggung_jawab', $sertifikat->penanggung_jawab) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[var(--accent)] focus:outline-none transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" :required="kategori === 'kas_desa'" placeholder="Contoh: Kepala Desa"
                            value="{{ old('jabatan', $sertifikat->jabatan) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[var(--accent)] focus:outline-none transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Unit Pengelola <span class="text-red-500">*</span></label>
                        <input type="text" name="unit_pengelola" :required="kategori === 'kas_desa'" placeholder="Contoh: Pemerintah Desa"
                            value="{{ old('unit_pengelola', $sertifikat->unit_pengelola) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[var(--accent)] focus:outline-none transition">
                    </div>
                </div>
            </div>

            {{-- ════════ C. LOKASI TANAH ════════ --}}
            <div>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[var(--primary)] border-b border-slate-100 pb-2">C. Lokasi Tanah</h3>
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Dukuh / Dusun <span class="text-red-500">*</span></label>
                        <select name="desa_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                            <option value="">— Pilih Dukuh —</option>
                            @foreach ($desas as $d)
                                <option value="{{ $d->id }}" {{ old('desa_id', $sertifikat->desa_id) == $d->id ? 'selected' : '' }}>{{ $d->dusun ?: $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">RT / RW</label>
                        <input type="text" name="rt_rw" placeholder="Contoh: 001/002"
                            value="{{ old('rt_rw', $sertifikat->rt_rw) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Blok</label>
                        <input type="text" name="blok" placeholder="Contoh: Blok A"
                            value="{{ old('blok', $sertifikat->blok) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Persil</label>
                        <input type="text" name="persil" placeholder="Nomor Persil"
                            value="{{ old('persil', $sertifikat->persil) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Jalan / Detail Alamat Lokasi</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap lokasi tanah..."
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">{{ old('alamat', $sertifikat->alamat) }}</textarea>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Latitude (Opsional)</label>
                        <input type="number" step="any" name="latitude" placeholder="-7.xxxxxx"
                            value="{{ old('latitude', (float)$sertifikat->latitude ?: '') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Longitude (Opsional)</label>
                        <input type="number" step="any" name="longitude" placeholder="110.xxxxxx"
                            value="{{ old('longitude', (float)$sertifikat->longitude ?: '') }}"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    </div>
                </div>
            </div>

            {{-- ════════ D. DATA FISIK ════════ --}}
            <div>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-[var(--primary)] border-b border-slate-100 pb-2">D. Data Fisik</h3>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Penggunaan Tanah</label>
                    <select name="penggunaan_tanah"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                        <option value="">— Pilih Penggunaan Tanah —</option>
                        @php
                            $selectedValue = old('penggunaan_tanah', $sertifikat->penggunaan_tanah);
                            $optionsList = $penggunaanTanahs->pluck('nama')->toArray();
                            if ($selectedValue && !in_array($selectedValue, $optionsList)) {
                                $optionsList[] = $selectedValue;
                            }
                        @endphp
                        @foreach($optionsList as $opsi)
                            <option value="{{ $opsi }}" {{ $selectedValue == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ─── Aksi ─── --}}
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 border-t border-slate-100 pt-6">
                <button type="submit"
                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                    <i class="fas fa-save"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.sertifikat.index') }}"
                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-8 py-3.5 text-sm font-bold text-[var(--text-muted)] transition hover:bg-slate-200">
                    <i class="fas fa-times"></i>Batal
                </a>
                <a href="{{ route('admin.sertifikat.show', $sertifikat) }}"
                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl border border-slate-200 px-8 py-3.5 text-sm font-bold text-[var(--text-muted)] transition hover:bg-slate-50 sm:ml-auto">
                    <i class="fas fa-eye text-xs"></i>Lihat Detail
                </a>
            </div>
        </form>
    </x-admin.form-card>
</div>
@endsection
