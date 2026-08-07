@extends('admin.layout')

@section('title', 'Daftar Dukuh')
@section('page-heading', 'Dukuh')

@section('content')
    <x-admin.page-header title="Kelola Dukuh"
        description="Atur data dukuh yang akan muncul saat menambahkan aset tanah.">
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <a href="{{ route('admin.desa.create') }}"
                class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                <i class="fas fa-plus"></i>Tambah Dukuh
            </a>
        </div>
    </x-admin.page-header>

    <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white shadow-lg overflow-hidden">
        <div class="border-b border-slate-100 p-6 bg-gradient-to-r from-[var(--bg)] to-white">
            <form method="GET" action="{{ route('admin.desa.index') }}" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                <div class="relative" x-data="{ query: '{{ request('search') }}' }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)] pointer-events-none">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" x-model="query"
                        placeholder="Cari nama dukuh..."
                        class="w-full rounded-3xl border border-slate-200 bg-white pl-11 pr-10 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                    <button type="button" x-show="query.length > 0" @click="query = ''; $nextTick(() => $el.closest('form').submit())" x-cloak
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-red-500 transition"
                        title="Hapus dan kembali ke awal">
                        <i class="fas fa-times-circle text-base"></i>
                    </button>
                </div>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] divide-y divide-slate-100 text-sm">
                <thead class="bg-[var(--bg)] text-[var(--text-muted)] whitespace-nowrap">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em] w-16">No</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Nama Dukuh</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Desa</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($desas as $desa)
                        <tr class="hover:bg-[var(--bg)]/50 transition-colors whitespace-nowrap">
                            <td class="px-4 py-3 sm:px-6 sm:py-4 text-[var(--text-muted)]">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4 font-semibold text-[var(--text)]">{{ $desa->dusun ?: '-' }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4 text-[var(--text-muted)]">{{ $desa->nama }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.desa.edit', $desa) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--accent)]/15 hover:text-[var(--accent)]"
                                        title="Edit data">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form id="form-hapus-desa-{{ $desa->id }}" method="POST" action="{{ route('admin.desa.destroy', $desa) }}" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button"
                                        onclick="openHapusModal('form-hapus-desa-{{ $desa->id }}', '{{ addslashes($desa->dusun ?: $desa->nama) }}', 'dukuh')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800"
                                        title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-[var(--text-muted)]">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                    <p>Tidak ada data dukuh ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($desas->hasPages())
            <div class="border-t border-slate-100 p-6 bg-[var(--bg)]/30">
                {{ $desas->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
let _hapusFormId = null;
function openHapusModal(formId, label, jenis) {
    _hapusFormId = formId;
    document.getElementById('hapus-label-global').innerHTML = '"' + label + '"' + (jenis ? ' (' + jenis + ')' : '');
    document.getElementById('hapus-modal-global').style.display = 'flex';
}
function closeHapusModal() {
    document.getElementById('hapus-modal-global').style.display = 'none';
    _hapusFormId = null;
}
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('hapus-confirm-btn');
    if (btn) btn.addEventListener('click', function () {
        if (_hapusFormId) document.getElementById(_hapusFormId).submit();
    });
});
</script>
@endsection
