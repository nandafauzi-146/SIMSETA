<div x-data="pencarianPublik()" class="w-full">
    <!-- Search Form -->
    <div class="bg-white/80 backdrop-blur-md rounded-lg p-6 border border-white/40 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Cek Status Aset Tanah Desa</h2>
        <form @submit.prevent="cari" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <input x-model="keyword" type="text" placeholder="Masukkan Alas Hak / Bukti Kepemilikan"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-primary pr-10"
                    required>
                <button type="button" x-show="keyword.length > 0" @click="resetForm()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 h-7 w-7 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition"
                    x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <button type="submit"
                class="bg-primary hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center gap-2 whitespace-nowrap"
                :disabled="loading">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                Cari
            </button>
        </form>
        <div x-show="showTurnstile" class="mt-4 flex justify-center" x-cloak>
            <div id="turnstile-container"></div>
        </div>
    </div>

    <!-- Loading -->
    <div x-show="loading" class="mt-4 text-center" x-cloak>
        <div class="inline-flex items-center gap-2 px-4 py-2 text-white bg-primary rounded-lg text-sm">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Mencari...
        </div>
    </div>

    <!-- Error -->
    <template x-if="error">
        <div class="mt-4 bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg text-sm">
            <p x-text="error"></p>
        </div>
    </template>

    <!-- Result -->
    <template x-if="sertifikat">
        <div class="mt-6 bg-white/90 backdrop-blur-md rounded-lg border border-white/40 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h3 class="text-xl font-bold">Hasil Pencarian</h3>
                        <p class="text-green-100 text-sm mt-1">Nomor: <span x-text="sertifikat.nomor_sertifikat"></span>
                        </p>
                    </div>
                    <span class="px-3 py-1 bg-white/20 rounded text-sm font-semibold"
                        x-text="sertifikat.status ?? '-'"></span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Alas Hak / Bukti Kepemilikan</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="sertifikat.nomor_sertifikat ?? '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Status</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="sertifikat.status ?? '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Luas (M²)</p>
                        <p class="text-lg text-gray-900 font-semibold"><span
                                x-text="formatLuas(sertifikat.luas)"></span> m²</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Lokasi</p>
                        <p class="text-gray-900 font-semibold"><span x-text="sertifikat.desa ?? '-'"></span></p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Alamat</p>
                        <p class="text-gray-700" x-text="sertifikat.alamat ?? '-'"></p>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                    <p class="text-blue-900 text-sm"><span class="font-semibold">Privasi:</span> Informasi pemilik tidak
                        ditampilkan di publik. Hubungi desa untuk verifikasi lebih lanjut.</p>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function pencarianPublik() {
        return {
            keyword: '',
            loading: false,
            error: null,
            sertifikat: null,
            showTurnstile: false,
            turnstileWidgetId: null,
            formatLuas(v) {
                return v ? new Intl.NumberFormat('id-ID').format(v) : '-';
            },
            cari() {
                if (this.loading || !this.keyword.trim()) return;
                this.error = null;
                this.sertifikat = null;
                this.showTurnstile = true;
                var self = this;
                this.$nextTick(function() {
                    if (self.turnstileWidgetId) {
                        turnstile.remove(self.turnstileWidgetId);
                        self.turnstileWidgetId = null;
                    }
                    self.turnstileWidgetId = turnstile.render('#turnstile-container', {
                        sitekey: '{{ config('services.turnstile.site_key') }}',
                        callback: function(token) {
                            self.prosesCari(token);
                        },
                        'error-callback': function() {
                            self.error = 'Verifikasi gagal. Silakan coba lagi.';
                            self.loading = false;
                            self.showTurnstile = false;
                            if (self.turnstileWidgetId) {
                                turnstile.remove(self.turnstileWidgetId);
                                self.turnstileWidgetId = null;
                            }
                        },
                        'expired-callback': function() {
                            turnstile.reset(self.turnstileWidgetId);
                        }
                    });
                });
            },
            prosesCari: function(token) {
                var self = this;
                self.loading = true;
                fetch("{{ route('public.search') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        keyword: self.keyword,
                        'cf-turnstile-response': token
                    })
                })
                .then(function(res) {
                    if (!res.ok) {
                        return res.json().then(function(data) {
                            throw new Error(data.message || 'Terjadi kesalahan server');
                        });
                    }
                    return res.json();
                })
                .then(function(data) {
                    self.loading = false;
                    self.sertifikat = data.sertifikat;
                    self.showTurnstile = false;
                    if (self.turnstileWidgetId) {
                        turnstile.remove(self.turnstileWidgetId);
                        self.turnstileWidgetId = null;
                    }
                })
                .catch(function(e) {
                    self.loading = false;
                    self.error = e.message;
                    self.showTurnstile = false;
                    if (self.turnstileWidgetId) {
                        turnstile.remove(self.turnstileWidgetId);
                        self.turnstileWidgetId = null;
                    }
                });
            },
            resetForm() {
                this.keyword = '';
                this.sertifikat = null;
                this.error = null;
                this.showTurnstile = false;
                if (this.turnstileWidgetId) {
                    turnstile.remove(this.turnstileWidgetId);
                    this.turnstileWidgetId = null;
                }
            }
        }
    }
</script>