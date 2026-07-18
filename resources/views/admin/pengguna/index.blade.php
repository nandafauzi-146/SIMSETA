@extends('admin.layout')

@section('title', 'Daftar Pengguna')
@section('page-heading', 'Pengguna')

@section('content')
    <x-admin.page-header title="Kelola Pengguna" description="Lihat status, peran, dan kelola akses pengguna.">
        <a href="{{ route('admin.pengguna.create') }}"
            class="inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
            <i class="fas fa-plus"></i>Tambah Pengguna
        </a>
    </x-admin.page-header>

    <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white shadow-lg overflow-hidden">
        <div class="border-b border-slate-100 p-6 bg-gradient-to-r from-[var(--bg)] to-white">
            <form method="GET" action="{{ route('admin.pengguna.index') }}" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)]">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email pengguna..."
                        class="w-full rounded-3xl border border-slate-200 bg-white pl-11 pr-4 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </div>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-[var(--bg)] text-[var(--text-muted)]">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Email</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Role</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Status</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.12em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($users as $user)
                        <tr class="hover:bg-[var(--bg)]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-[var(--text)]">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-[var(--text-muted)]">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-[var(--text-muted)]">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
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
                                        <form method="POST" action="{{ route('admin.pengguna.destroy', $user) }}" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800"
                                                title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
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
