@extends('admin.layout')

@section('title', 'Tambah Aset Tanah')

@section('content')
    <div class="mx-auto max-w-7xl">
        <x-admin.page-header title="Tambah Aset Tanah Baru"
            description="Catat data aset tanah desa dengan informasi yang lengkap agar dapat dipantau dengan mudah." />

        <x-admin.form-card>
            <form method="POST" action="{{ route('admin.sertifikat.store') }}">
                @csrf

                <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Desa / Dusun *</label>
                        <select name="desa_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('desa_id') border-red-500 @enderror">
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>
                                    {{ $desa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Status *</label>
                        <select name="status_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('status_id') border-red-500 @enderror">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Jenis Hak *</label>
                        <select name="jenis_hak_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('jenis_hak_id') border-red-500 @enderror">
                            @foreach ($jenis_haks as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_hak_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Pemilik *</label>
                        <select name="pemilik_id" required
                            class="w-full rounded-2xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('pemilik_id') border-red-500 @enderror">
                            @forelse ($pemiliks as $pemilik)
                                <option value="{{ $pemilik->id }}" {{ old('pemilik_id') == $pemilik->id ? 'selected' : '' }}>
                                    {{ $pemilik->nama }}
                                </option>
                            @empty
                                <option value="">-- Belum ada pemilik --</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-[var(--text-muted)]">NO</th>
                                <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-[var(--text-muted)]">Luas (M²)</th>
                                <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-[var(--text-muted)]">Tahun Perolehan</th>
                                <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-[var(--text-muted)]">Alas Hak / Bukti Kepemilikan</th>
                                <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.12em] text-[var(--text-muted)]">Keterangan</th>
                                <th class="w-12 px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody id="baris-aset">
                            <tr class="border-b border-slate-100 hover:bg-[var(--bg)]/50 transition">
                                <td class="px-4 py-3">
                                    <span class="block w-14 py-2.5 text-sm text-[var(--text-muted)] text-center">1</span>
                                    <input type="hidden" name="items[0][no]" value="1">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[0][luas_tanah]" required
                                        placeholder="0.00"
                                        class="w-28 rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('items.0.luas_tanah') border-red-500 @enderror">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[0][tahun_perolehan]"
                                        placeholder="2026"
                                        class="w-28 rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('items.0.tahun_perolehan') border-red-500 @enderror">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[0][nomor_sertifikat]" required
                                        placeholder="M.1234 / HGB.567"
                                        class="w-full min-w-[180px] rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('items.0.nomor_sertifikat') border-red-500 @enderror">
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" name="items[0][deskripsi]"
                                        placeholder="Catatan opsional"
                                        class="w-full min-w-[180px] rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition @error('items.0.deskripsi') border-red-500 @enderror">
                                </td>
                                <td class="px-4 py-3 text-sm text-[var(--text-muted)] text-center">1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-6">
                    <button type="button" id="tambah-baris"
                        class="inline-flex items-center gap-2 rounded-3xl border border-dashed border-[var(--primary)]/30 bg-[var(--bg)] px-5 py-2.5 text-sm font-semibold text-[var(--primary)] transition hover:border-[var(--primary)] hover:bg-[var(--primary)]/5">
                        <i class="fas fa-plus"></i>Tambah Baris
                    </button>
                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                            <i class="fas fa-save"></i>Simpan Semua
                        </button>
                        <a href="{{ route('admin.sertifikat.index') }}"
                            class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </x-admin.form-card>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('baris-aset');
        const tambahBtn = document.getElementById('tambah-baris');
        let counter = 1;

        tambahBtn.addEventListener('click', function() {
            counter++;
            const idx = counter;
            const tr = document.createElement('tr');
            tr.className = 'border-b border-slate-100 hover:bg-[var(--bg)]/50 transition';
            tr.innerHTML = `
                <td class="px-4 py-3">
                    <span class="block w-14 py-2.5 text-sm text-[var(--text-muted)] text-center baris-no">${idx}</span>
                    <input type="hidden" name="items[${idx}][no]" value="${idx}">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${idx}][luas_tanah]" required placeholder="0.00"
                        class="w-28 rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${idx}][tahun_perolehan]" placeholder="2026"
                        class="w-28 rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${idx}][nomor_sertifikat]" required placeholder="M.1234 / HGB.567"
                        class="w-full min-w-[180px] rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${idx}][deskripsi]" placeholder="Catatan opsional"
                        class="w-full min-w-[180px] rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-3 py-2.5 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" class="hapus-baris inline-flex h-8 w-8 items-center justify-center rounded-xl text-red-500 transition hover:bg-red-50 hover:text-red-700" title="Hapus baris">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            updateNomor();
        });

        tbody.addEventListener('click', function(e) {
            const btn = e.target.closest('.hapus-baris');
            if (!btn) return;
            const row = btn.closest('tr');
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                updateNomor();
            }
        });

        function updateNomor() {
            const rows = tbody.querySelectorAll('tr');
            rows.forEach(function(row, i) {
                const noSpan = row.querySelector('.baris-no');
                const noInput = row.querySelector('input[name$="[no]"]');
                const num = i + 1;
                if (noSpan) noSpan.textContent = num;
                if (noInput) noInput.value = num;
                const inputs = row.querySelectorAll('input[name^="items["]');
                inputs.forEach(function(inp) {
                    const name = inp.getAttribute('name');
                    if (name) inp.setAttribute('name', name.replace(/items\[\d+\]/, 'items[' + i + ']'));
                });
            });
        }
    });
</script>
