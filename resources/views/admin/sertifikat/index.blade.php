@extends('admin.layout')

@section('title', 'Daftar Aset Tanah')
@section('page-heading', 'Aset Tanah')

@section('content')
    <x-admin.page-header title="Daftar Aset Tanah"
        description="Kelola data aset tanah desa, cari berdasarkan alas hak, dan pantau status setiap bidang secara cepat.">
        <a href="{{ route('admin.sertifikat.create') }}"
            class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
            <i class="fas fa-plus"></i>Tambah Aset Tanah
        </a>
    </x-admin.page-header>

    <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white shadow-lg overflow-hidden">
        <div class="border-b border-slate-100 p-6 bg-gradient-to-r from-[var(--bg)] to-white">
            <form method="GET" action="{{ route('admin.sertifikat.index') }}" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <select name="desa_id"
                        class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                        <option value="">Semua Dusun</option>
                        @foreach ($desas as $desa)
                            <option value="{{ $desa->id }}" {{ request('desa_id') == $desa->id ? 'selected' : '' }}>
                                {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="tahun"
                        class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahuns as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)]">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari alas hak, dusun, atau data aset tanah..."
                        class="w-full rounded-3xl border border-slate-200 bg-white pl-11 pr-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm flex-1">
                        Cari
                    </button>
                    <a href="{{ route('admin.sertifikat.index') }}"
                        class="inline-flex items-center justify-center rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200 shadow-sm">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-[var(--bg)] text-[var(--text-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Bukti Kepemilikan</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Dusun / Lokasi</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Luas (M²)</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Status</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($sertifikats as $sertifikat)
                        <tr class="hover:bg-[var(--bg)]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-[var(--text)]">{{ $sertifikat->nomor_sertifikat }}</td>
                            <td class="px-6 py-4 text-[var(--text-muted)]">{{ $sertifikat->desa->nama ?? '-' }}</td>
                            <td class="px-6 py-4 font-medium text-[var(--text)]">
                                {{ number_format((float) $sertifikat->luas, 0, ',', '.') }} m²
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $sertifikat->trashed() ? 'bg-red-50 text-red-600 border border-red-200' : ($sertifikat->status->nama === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-[var(--accent)]/10 text-[var(--accent)] border border-[var(--accent)]/20') }}">
                                    @if ($sertifikat->trashed())
                                        <i class="fas fa-trash mr-1"></i>
                                    @endif
                                    {{ $sertifikat->trashed() ? 'Dihapus' : ($sertifikat->status->nama ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.sertifikat.show', $sertifikat) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--primary)]/10 hover:text-[var(--primary)]"
                                        title="Lihat detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    @if (!$sertifikat->trashed())
                                        <a href="{{ route('admin.sertifikat.edit', $sertifikat) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--accent)]/15 hover:text-[var(--accent)]"
                                            title="Edit data">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.sertifikat.destroy', $sertifikat) }}"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800"
                                                title="Hapus data">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if ($sertifikat->trashed())
                                        <form method="POST" action="{{ route('admin.sertifikat.restore', $sertifikat->id) }}"
                                            class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition hover:bg-emerald-100 hover:text-emerald-800"
                                                title="Pulihkan data">
                                                <i class="fas fa-undo text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[var(--text-muted)]">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                    <p>Tidak ada data aset tanah ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sertifikats->hasPages())
            <div class="border-t border-slate-100 p-6 bg-[var(--bg)]/30">
                {{ $sertifikats->links() }}
            </div>
        @endif
    </div>
@endsection
