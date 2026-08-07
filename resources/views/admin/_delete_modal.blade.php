{{-- Modal Konfirmasi Hapus (global) --}}
<div id="hapus-modal-global"
    style="display:none"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4"
    onclick="if(event.target===this) closeHapusModal()">
    <div class="w-full max-w-xs animate-modal rounded-xl bg-white p-5 shadow-2xl">
        <div class="flex flex-col items-center text-center">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 mb-3">
                <i class="fas fa-trash-alt text-sm text-red-500"></i>
            </div>
            <h3 class="text-sm font-bold text-[var(--text)]">Hapus Data?</h3>
            <p class="mt-0.5 text-xs text-[var(--text-muted)]">Apakah Anda yakin ingin menghapus <b
                    id="hapus-label-global"></b>?</p>
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