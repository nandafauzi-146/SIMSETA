@extends('admin.layout')

@section('title', 'Penggunaan Tanah')
@section('page-heading', 'Penggunaan Tanah')

@section('content')
    <x-admin.page-header title="Kelola Penggunaan Tanah"
        description="Atur daftar opsi dropdown Penggunaan Tanah yang tersedia saat penginputan sertifikat tanah.">
        <div class="w-full sm:w-auto mt-4 sm:mt-0">
            <button type="button" onclick="openTambahModal()"
                class="w-full sm:w-auto justify-center inline-flex items-center gap-2 rounded-3xl bg-[var(--primary)] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-[var(--primary-dark)]">
                <i class="fas fa-plus"></i>Tambah Opsi Baru
            </button>
        </div>
    </x-admin.page-header>

    <div class="space-y-6">
        <div class="rounded-[2rem] border border-[var(--primary)]/15 bg-white shadow-lg overflow-hidden">
            {{-- Field Pencarian --}}
            <div class="border-b border-slate-100 p-6 bg-gradient-to-r from-[var(--bg)] to-white">
                <form method="GET" action="{{ route('admin.penggunaan-tanah.index') }}" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                    <div class="relative" x-data="{ query: '{{ request('search') }}' }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)] pointer-events-none">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" x-model="query"
                            placeholder="Cari jenis penggunaan tanah..."
                            class="w-full rounded-3xl border border-slate-200 bg-white pl-11 pr-10 py-3 text-sm text-[var(--text)] focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                        <button type="button" x-show="query.length > 0" @click="query = ''; $nextTick(() => $el.closest('form').submit())" x-cloak
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-red-500 transition"
                            title="Hapus pencarian">
                            <i class="fas fa-times-circle text-base"></i>
                        </button>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-3xl bg-[var(--primary)] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Header Informasi --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <p class="text-xs font-semibold text-[var(--text-muted)]">
                    @if(request('search'))
                        Menampilkan hasil pencarian "{{ request('search') }}" ({{ count($items) }} ditemukan)
                    @else
                        Total {{ count($items) }} opsi terdaftar dalam sistem.
                    @endif
                </p>
                <span class="rounded-full bg-[var(--primary)]/10 px-3 py-1 text-xs font-semibold text-[var(--primary)]">
                    <i class="fas fa-seedling mr-1"></i>Master Data
                </span>
            </div>

            {{-- Tabel Daftar Penggunaan --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] divide-y divide-slate-100 text-sm">
                    <thead class="bg-[var(--bg)] text-[var(--text-muted)] whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em] w-16 text-center">No</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left font-semibold uppercase tracking-[0.12em]">Nama Jenis Penggunaan</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-right font-semibold uppercase tracking-[0.12em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($items as $index => $item)
                            <tr class="hover:bg-[var(--bg)]/50 transition-colors whitespace-nowrap">
                                <td class="px-4 py-3 sm:px-6 sm:py-4 text-[var(--text-muted)] text-center font-medium">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 font-semibold text-[var(--text)]">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-[var(--primary)]"></span>
                                        {{ $item->nama }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->nama) }}')"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[var(--bg)] text-[var(--text-muted)] transition hover:bg-[var(--primary)]/15 hover:text-[var(--primary)]"
                                            title="Edit nama">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>

                                        <button type="button" onclick="openHapusModal({{ $item->id }}, '{{ addslashes($item->nama) }}')"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 transition hover:bg-red-100 hover:text-red-800"
                                            title="Hapus opsi">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-[var(--text-muted)]">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-seedling text-3xl text-slate-300"></i>
                                        <p>Tidak ada opsi penggunaan tanah ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah (Mengikuti Style Modal System / Logout) --}}
    <div id="tambah-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
        onclick="if(event.target===this) document.getElementById('tambah-modal').classList.add('hidden')">
        <div class="w-full max-w-xs sm:max-w-sm animate-modal rounded-xl bg-white p-5 shadow-2xl">
            <div class="flex flex-col items-center text-center mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--primary)]/10 text-[var(--primary)] mb-3">
                    <i class="fas fa-plus text-sm"></i>
                </div>
                <h3 class="text-sm font-bold text-[var(--text)]">Tambah Jenis Penggunaan Baru</h3>
                <p class="mt-0.5 text-xs text-[var(--text-muted)]">Masukkan nama opsi penggunaan tanah yang akan ditambahkan.</p>
            </div>
            <form method="POST" action="{{ route('admin.penggunaan-tanah.store') }}">
                @csrf
                <div class="mb-4">
                    <input type="text" name="nama" placeholder="Contoh: Perkebunan, Kolam, Ruko" required autofocus
                        class="w-full rounded-lg border border-slate-200 bg-[var(--bg)]/50 px-3.5 py-2.5 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/20 transition">
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('tambah-modal').classList.add('hidden')"
                        class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[var(--text)] transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-lg bg-[var(--primary)] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm">
                        <i class="fas fa-save mr-1.5"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit (Mengikuti Style Modal System / Logout) --}}
    <div id="edit-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
        onclick="if(event.target===this) document.getElementById('edit-modal').classList.add('hidden')">
        <div class="w-full max-w-xs sm:max-w-sm animate-modal rounded-xl bg-white p-5 shadow-2xl">
            <div class="flex flex-col items-center text-center mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-600 mb-3">
                    <i class="fas fa-edit text-sm"></i>
                </div>
                <h3 class="text-sm font-bold text-[var(--text)]">Edit Jenis Penggunaan Tanah</h3>
                <p class="mt-0.5 text-xs text-[var(--text-muted)]">Perbarui nama opsi penggunaan tanah.</p>
            </div>
            <form id="form-edit-penggunaan" method="POST" action="">
                @csrf @method('PUT')
                <div class="mb-4">
                    <input type="text" id="edit-nama-input" name="nama" required autofocus
                        class="w-full rounded-lg border border-slate-200 bg-[var(--bg)]/50 px-3.5 py-2.5 text-sm focus:border-[var(--primary)] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[var(--primary)]/20 transition">
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')"
                        class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[var(--text)] transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-lg bg-[var(--primary)] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[var(--primary-dark)] shadow-sm">
                        <i class="fas fa-save mr-1.5"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus (Mengikuti Style Logout Modal) --}}
    <div id="hapus-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
        onclick="if(event.target===this) document.getElementById('hapus-modal').classList.add('hidden')">
        <div class="w-full max-w-xs animate-modal rounded-xl bg-white p-5 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 mb-3">
                    <i class="fas fa-trash-alt text-sm text-red-500"></i>
                </div>
                <h3 class="text-sm font-bold text-[var(--text)]">Hapus Jenis Penggunaan?</h3>
                <p class="mt-0.5 text-xs text-[var(--text-muted)]">Apakah Anda yakin ingin menghapus opsi <b id="hapus-nama-text"></b>?</p>
            </div>
            <div class="mt-4 flex gap-2">
                <button type="button" onclick="document.getElementById('hapus-modal').classList.add('hidden')"
                    class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-[var(--text)] transition hover:bg-slate-50">
                    Batal
                </button>
                <form id="form-hapus-penggunaan" method="POST" action="" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">
                        <i class="fas fa-trash-alt mr-1.5"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openTambahModal() {
        document.getElementById('tambah-modal').classList.remove('hidden');
    }

    function openEditModal(id, nama) {
        const modal = document.getElementById('edit-modal');
        const form = document.getElementById('form-edit-penggunaan');
        const input = document.getElementById('edit-nama-input');
        form.action = `/admin/penggunaan-tanah/${id}`;
        input.value = nama;
        modal.classList.remove('hidden');
    }

    function openHapusModal(id, nama) {
        const modal = document.getElementById('hapus-modal');
        const form = document.getElementById('form-hapus-penggunaan');
        const text = document.getElementById('hapus-nama-text');
        form.action = `/admin/penggunaan-tanah/${id}`;
        text.textContent = `"${nama}"`;
        modal.classList.remove('hidden');
    }
    </script>
@endsection
