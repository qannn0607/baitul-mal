<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ 
        tab: 'maal',
        goldPrice: {{ $nisabGoldPrice }},
        
        // Zakat Maal State
        totalHarta: 0,
        hutang: 0,
        get nettoMaal() { return Math.max(0, (parseFloat(this.totalHarta) || 0) - (parseFloat(this.hutang) || 0)); },
        get nisabMaal() { return 85 * this.goldPrice; },
        get isWajibMaal() { return this.nettoMaal >= this.nisabMaal; },
        get nominalZakatMaal() { return this.isWajibMaal ? Math.round(this.nettoMaal * 0.025) : 0; },

        // Zakat Penghasilan State
        penghasilan: 0,
        kebutuhan: 0,
        get nettoPenghasilan() { return Math.max(0, (parseFloat(this.penghasilan) || 0) - (parseFloat(this.kebutuhan) || 0)); },
        get nisabPenghasilanMonthly() { return Math.round((85 * this.goldPrice) / 12); },
        get isWajibPenghasilan() { return this.nettoPenghasilan >= this.nisabPenghasilanMonthly; },
        get nominalZakatPenghasilan() { return this.isWajibPenghasilan ? Math.round(this.nettoPenghasilan * 0.025) : 0; },

        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }
    }">

        <!-- Header Title -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Kalkulator Zakat</span>
                <h1 class="text-2xl font-bold text-slate-900 mt-2">Hitung Kewajiban Zakat Anda</h1>
                <p class="text-sm text-slate-500 mt-1">Hitung zakat Maal & Penghasilan berdasarkan acuan Nisab Emas 85 Gram (Rp {{ number_format($nisabGoldPrice, 0, ',', '.') }}/gram).</p>
            </div>
            
            <!-- Tab Switcher -->
            <div class="flex items-center p-1.5 bg-slate-100 rounded-2xl w-full sm:w-auto">
                <button type="button" @click="tab = 'maal'" :class="tab === 'maal' ? 'bg-white text-emerald-800 shadow-md font-bold' : 'text-slate-600 font-semibold'" class="px-5 py-2.5 rounded-xl text-sm transition-all w-1/2 sm:w-auto">
                    Zakat Maal
                </button>
                <button type="button" @click="tab = 'penghasilan'" :class="tab === 'penghasilan' ? 'bg-white text-emerald-800 shadow-md font-bold' : 'text-slate-600 font-semibold'" class="px-5 py-2.5 rounded-xl text-sm transition-all w-1/2 sm:w-auto">
                    Zakat Penghasilan
                </button>
            </div>
        </div>

        <!-- TAB 1: ZAKAT MAAL -->
        <div x-show="tab === 'maal'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Input Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-4">
                <h2 class="text-lg font-bold text-slate-900 border-b pb-3">Input Harta & Tabungan</h2>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Total Harta Tabungan & Emas (Rp)</label>
                    <input type="number" x-model="totalHarta" placeholder="0" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-lg font-semibold" />
                    <p class="text-xs text-slate-400 mt-1">Termasuk simpanan tabungan, deposito, perhiasan emas yang disimpan 1 tahun.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Hutang / Kewajiban Jatuh Tempo (Rp)</label>
                    <input type="number" x-model="hutang" placeholder="0" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-lg font-semibold" />
                    <p class="text-xs text-slate-400 mt-1">Hutang yang harus dilunasi dalam waktu dekat.</p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl text-xs space-y-1 text-slate-600 border border-slate-100">
                    <p>• <strong>Nisab Zakat Maal (85 gr emas):</strong> <span class="font-bold text-slate-800" x-text="formatRupiah(nisabMaal)"></span></p>
                    <p>• <strong>Kadar Zakat:</strong> 2.5% dari harta bersih</p>
                </div>
            </div>

            <!-- Output Result Card -->
            <div class="bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-emerald-300 uppercase tracking-wider">Hasil Perhitungan Zakat Maal</h3>
                    
                    <div class="mt-6 space-y-4">
                        <div>
                            <p class="text-xs text-emerald-200">Harta Bersih Kena Zakat:</p>
                            <p class="text-xl font-bold text-white" x-text="formatRupiah(nettoMaal)"></p>
                        </div>

                        <!-- Nisab Status -->
                        <div>
                            <p class="text-xs text-emerald-200 mb-1">Status Kewajiban Zakat:</p>
                            <template x-if="isWajibMaal">
                                <span class="px-3 py-1 bg-emerald-500 text-emerald-950 font-extrabold text-xs rounded-full">
                                    ✅ WAJIB ZAKAT (Mencapai Nisab)
                                </span>
                            </template>
                            <template x-if="!isWajibMaal">
                                <span class="px-3 py-1 bg-amber-400/90 text-amber-950 font-bold text-xs rounded-full">
                                    ℹ️ BELUM WAJIB ZAKAT (Di bawah Nisab)
                                </span>
                            </template>
                        </div>

                        <div class="pt-4 border-t border-emerald-800">
                            <p class="text-xs text-emerald-200">Total Zakat Wajib Dibayar (2.5%):</p>
                            <p class="text-3xl font-extrabold text-emerald-300 mt-1" x-text="formatRupiah(nominalZakatMaal)"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a :href="'{{ route('zakat.pay') }}?amount=' + nominalZakatMaal + '&title=Zakat Maal'" 
                       class="w-full py-3.5 px-4 bg-emerald-500 hover:bg-emerald-400 text-emerald-950 font-bold rounded-2xl shadow-lg transition-all text-center block"
                       :class="nominalZakatMaal > 0 ? '' : 'opacity-60 cursor-not-allowed'">
                        Bayar Zakat Maal Ini Sekarang &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- TAB 2: ZAKAT PENGHASILAN -->
        <div x-show="tab === 'penghasilan'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Input Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 space-y-4">
                <h2 class="text-lg font-bold text-slate-900 border-b pb-3">Input Gaji & Penghasilan Bulanan</h2>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Total Penghasilan per Bulan (Rp)</label>
                    <input type="number" x-model="penghasilan" placeholder="0" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-lg font-semibold" />
                    <p class="text-xs text-slate-400 mt-1">Gaji pokok, bonus, komisi, dan penghasilan tambahan per bulan.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kebutuhan Pokok per Bulan (Rp)</label>
                    <input type="number" x-model="kebutuhan" placeholder="0" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-lg font-semibold" />
                    <p class="text-xs text-slate-400 mt-1">Biaya hidup pokok & angsuran rutin per bulan.</p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl text-xs space-y-1 text-slate-600 border border-slate-100">
                    <p>• <strong>Nisab Per Bulan (85 gr emas / 12):</strong> <span class="font-bold text-slate-800" x-text="formatRupiah(nisabPenghasilanMonthly)"></span></p>
                    <p>• <strong>Kadar Zakat:</strong> 2.5% dari penghasilan bersih</p>
                </div>
            </div>

            <!-- Output Result Card -->
            <div class="bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-emerald-300 uppercase tracking-wider">Hasil Perhitungan Zakat Penghasilan</h3>
                    
                    <div class="mt-6 space-y-4">
                        <div>
                            <p class="text-xs text-emerald-200">Penghasilan Bersih Bulanan:</p>
                            <p class="text-xl font-bold text-white" x-text="formatRupiah(nettoPenghasilan)"></p>
                        </div>

                        <!-- Nisab Status -->
                        <div>
                            <p class="text-xs text-emerald-200 mb-1">Status Kewajiban Zakat:</p>
                            <template x-if="isWajibPenghasilan">
                                <span class="px-3 py-1 bg-emerald-500 text-emerald-950 font-extrabold text-xs rounded-full">
                                    ✅ WAJIB ZAKAT (Mencapai Nisab Bulanan)
                                </span>
                            </template>
                            <template x-if="!isWajibPenghasilan">
                                <span class="px-3 py-1 bg-amber-400/90 text-amber-950 font-bold text-xs rounded-full">
                                    ℹ️ BELUM WAJIB ZAKAT (Di bawah Nisab Bulanan)
                                </span>
                            </template>
                        </div>

                        <div class="pt-4 border-t border-emerald-800">
                            <p class="text-xs text-emerald-200">Total Zakat Wajib Dibayar (2.5%):</p>
                            <p class="text-3xl font-extrabold text-emerald-300 mt-1" x-text="formatRupiah(nominalZakatPenghasilan)"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a :href="'{{ route('zakat.pay') }}?amount=' + nominalZakatPenghasilan + '&title=Zakat Penghasilan'" 
                       class="w-full py-3.5 px-4 bg-emerald-500 hover:bg-emerald-400 text-emerald-950 font-bold rounded-2xl shadow-lg transition-all text-center block"
                       :class="nominalZakatPenghasilan > 0 ? '' : 'opacity-60 cursor-not-allowed'">
                        Bayar Zakat Penghasilan Ini Sekarang &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
