@extends('admin.layout')

@section('title', 'Dokumen - ' . $sertifikat->nomor_sertifikat)

@section('content')
<div class="mx-auto max-w-4xl">
    <x-admin.page-header
        title="Dokumen: {{ $sertifikat->nomor_sertifikat }}"
        description="Kelola file pendukung aset tanah ini.">
        <a href="{{ route('admin.sertifikat.show', $sertifikat) }}"
            class="inline-flex items-center gap-2 rounded-3xl bg-slate-100 px-5 py-2.5 text-sm font-semibold text-[var(--text-muted)] transition hover:bg-slate-200">
            <i class="fas fa-arrow-left"></i>Kembali
        </a>
    </x-admin.page-header>

    <x-admin.form-card>
        <form method="POST" action="{{ route('admin.sertifikat.dokumen.store', $sertifikat) }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="grid gap-4 sm:grid-cols-[1fr_1fr_auto] items-end">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">Nama Dokumen</label>
                    <input type="text" name="nama_file" placeholder="Contoh: Scan Sertifikat"
                        class="w-full rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-2.5 text-sm focus:border-[var(--primary)] focus:outline-none focus:ring-4 focus:ring-[var(--primary)]/10 transition">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[var(--text)]">File (Max 10MB)</label>
                    <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        class="w-full rounded-xl border border-slate-200 bg-[var(--bg)]/50 px-4 py-2.5 text-sm file:mr-4 file:rounded-xl file:border-0 file:bg-[var(--primary)] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[var(--primary-dark)] transition">
                </div>
                <button type="submit"
                    class="rounded-xl bg-[var(--primary)] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[var(--primary-dark)] transition">
                    <i class="fas fa-upload mr-2"></i>Upload
                </button>
            </div>
        </form>

        @if($dokumens->isEmpty())
            <div class="text-center py-8 text-[var(--text-muted)]">
                <i class="fas fa-file-alt text-3xl text-slate-300 mb-2"></i>
                <p>Belum ada dokumen</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($dokumens as $d)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file text-lg text-[var(--primary)]"></i>
                            <div>
                                <p class="text-sm font-medium text-[var(--text)]">{{ $d->nama_file }}</p>
                                <p class="text-xs text-[var(--text-muted)]">{{ strtoupper($d->jenis_file) }} — {{ $d->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.sertifikat.dokumen.download', [$sertifikat, $d]) }}"
                                class="rounded-xl bg-blue-50 px-3 py-2 text-sm text-blue-600 hover:bg-blue-100 transition">
                                <i class="fas fa-download"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.sertifikat.dokumen.destroy', [$sertifikat, $d]) }}"
                                onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="rounded-xl bg-red-50 px-3 py-2 text-sm text-red-600 hover:bg-red-100 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-admin.form-card>
</div>
@endsection
