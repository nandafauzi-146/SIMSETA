@extends('admin.layout')

@section('title', 'Edit Aset Tanah')

@section('content')
    <div class="mx-auto max-w-5xl">
        <x-admin.page-header title="Edit Aset Tanah"
            description="Perbarui informasi aset tanah desa agar data tetap akurat dan mudah ditelusuri." />

        <x-admin.form-card>
            <form method="POST" action="{{ route('admin.sertifikat.update', $sertifikat) }}" class="space-y-6">
                @csrf @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Alas Hak / Bukti Kepemilikan *</label>
                        <input type="text" name="nomor_sertifikat" required
                            placeholder="Contoh: M.1234 atau HGB.567"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('nomor_sertifikat') border-red-500 @enderror"
                            value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat) }}">
                        @error('nomor_sertifikat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Referensi Pemilik *</label>
                        <select name="pemilik_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('pemilik_id') border-red-500 @enderror">
                            @foreach ($pemiliks as $pemilik)
                                <option value="{{ $pemilik->id }}" {{ old('pemilik_id', $sertifikat->pemilik_id) == $pemilik->id ? 'selected' : '' }}>
                                    {{ $pemilik->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pemilik_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Jenis Hak *</label>
                        <select name="jenis_hak_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('jenis_hak_id') border-red-500 @enderror">
                            @foreach ($jenis_haks as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_hak_id', $sertifikat->jenis_hak_id) == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_hak_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Status *</label>
                        <select name="status_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('status_id') border-red-500 @enderror">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id', $sertifikat->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Dusun / Lokasi *</label>
                        <select name="desa_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('desa_id') border-red-500 @enderror">
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}" {{ old('desa_id', $sertifikat->desa_id) == $desa->id ? 'selected' : '' }}>
                                    {{ $desa->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('desa_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Luas (M²) *</label>
                        <input type="number" name="luas" required step="0.01"
                            placeholder="Contoh: 1500"
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('luas') border-red-500 @enderror"
                            value="{{ old('luas', $sertifikat->luas) }}">
                        @error('luas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Keterangan / Catatan</label>
                    <textarea name="alamat" rows="4"
                        placeholder="Masukkan keterangan tambahan..."
                        class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('alamat') border-red-500 @enderror">{{ old('alamat', $sertifikat->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                        <i class="fas fa-save"></i>Perbarui
                    </button>
                    <a href="{{ route('admin.sertifikat.index') }}"
                        class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </x-admin.form-card>
    </div>
@endsection
