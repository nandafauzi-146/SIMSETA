@extends('admin.layout')

@section('title', 'Daftar Pengguna')
@section('page-heading', 'Pengguna')

@section('content')
    <x-admin.page-header title="Kelola Pengguna" description="Lihat status, peran, dan kelola akses pengguna.">
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <a href="{{ route('admin.pengguna.create') }}"
                class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                <i class="fas fa-plus"></i>Tambah Pengguna
            </a>
        </div>
    </x-admin.page-header>

    <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white shadow-lg overflow-hidden">
        <div class="border-b border-slate-100 p-6 bg-gradient-to-r from-[var(--bg)] to-white">
            <form method="GET" action="{{ route('admin.pengguna.index') }}" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                <div class="relative" x-data="{ query: '{{ request('search') }}' }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)] pointer-events-none">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" x-model="query"
                        placeholder="Cari nama atau email pengguna..."
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
            <table class="w-full min-w-[640px] divide-y divide-slate-100 text-sm">
                <thead class="bg-[var(--bg)] text-[var(--text-muted)] whitespace-nowrap">
                    <tr>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Nama</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Email</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Role</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Status</th>
                        <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[var(--bg)]/50 transition-colors whitespace-nowrap">
                            <td class="px-4 py-3 sm:px-6 sm:py-4 font-semibold text-[var(--text)]">{{ $user->name }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4 text-[var(--text-muted)]">{{ $user->email }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4 text-[var(--text-muted)]">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4">
                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 sm:px-6 sm:py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.pengguna.show', $user) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--primary)]/10 hover:text-[var(--primary)]"
                                        title="Lihat detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.pengguna.edit', $user) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--accent)]/15 hover:text-[var(--accent)]"
                                        title="Edit data">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    @if (auth()->id() !== $user->id)
                                        <form id="form-hapus-pengguna-{{ $user->id }}" method="POST" action="{{ route('admin.pengguna.destroy', $user) }}" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button"
                                            onclick="openHapusModal('form-hapus-pengguna-{{ $user->id }}', '{{ addslashes($user->name) }}', 'pengguna')"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800"
                                            title="Hapus">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[var(--text-muted)]">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                    <p>Tidak ada data pengguna ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-slate-100 p-6 bg-[var(--bg)]/30">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

{{-- Modal Konfirmasi Hapus --}}
<div id="hapus-modal-global"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
    onclick="if(event.target===this) closeHapusModal()">
    <div class="w-full max-w-xs animate-modal rounded-xl bg-white p-5 shadow-2xl">
        <div class="flex flex-col items-center text-center">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 mb-3">
                <i class="fas fa-trash-alt text-sm text-red-500"></i>
            </div>
            <h3 class="text-sm font-bold text-[var(--text)]">Hapus Data?</h3>
            <p class="mt-0.5 text-xs text-[var(--text-muted)]">Apakah Anda yakin ingin menghapus <b id="hapus-label-global"></b>?</p>
        </div>
        <div class="mt-4 flex gap-2">
            <button type="button" onclick="closeHapusModal()"
                class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[var(--text)] transition hover:bg-slate-50">
                Batal
            </button>
            <button type="button" id="hapus-confirm-btn"
                class="flex-1 rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                <i class="fas fa-trash-alt mr-1.5"></i>Hapus
            </button>
        </div>
    </div>
</div>

@section('scripts')
<script>
let _hapusFormId = null;
function openHapusModal(formId, label, jenis) {
    _hapusFormId = formId;
    document.getElementById('hapus-label-global').innerHTML = '"' + label + '"' + (jenis ? ' (' + jenis + ')' : '');
    document.getElementById('hapus-modal-global').classList.remove('hidden');
}
function closeHapusModal() {
    document.getElementById('hapus-modal-global').classList.add('hidden');
    _hapusFormId = null;
}
document.getElementById('hapus-confirm-btn').addEventListener('click', function () {
    if (_hapusFormId) document.getElementById(_hapusFormId).submit();
});
</script>
@endsection
