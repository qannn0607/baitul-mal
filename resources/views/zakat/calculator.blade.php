<?php
    $setting = \App\Models\Setting::first();
    $nisabGoldPrice = $setting->nisab_gold_price ?? 1400000;
    $nisabAnnualMaal = $nisabGoldPrice * 85;
    $nisabMonthlyIncome = $nisabAnnualMaal / 12;
    $fitrahNominal = $setting->zakat_fitrah_nominal ?? 45000;
?>

<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8" 
         x-data="{
             type: 'penghasilan',
             
             // Inputs Penghasilan
             monthlyIncome: 10000000,
             monthlyBonus: 0,
             monthlyNeeds: 2000000,

             // Inputs Maal
             savings: 120000000,
             goldGrams: 0,

             // Inputs Fitrah
             fitrahCount: 1,

             // Constants
             nisabGoldPrice: {{ $nisabGoldPrice }},
             nisabAnnualMaal: {{ $nisabAnnualMaal }},
             nisabMonthlyIncome: {{ $nisabMonthlyIncome }},
             fitrahNominal: {{ $fitrahNominal }},

             // Computed Results
             get totalPenghasilanNet() {
                 return Math.max(0, (parseInt(this.monthlyIncome || 0) + parseInt(this.monthlyBonus || 0)) - parseInt(this.monthlyNeeds || 0));
             },
             get isPenghasilanWajib() {
                 return (parseInt(this.monthlyIncome || 0) + parseInt(this.monthlyBonus || 0)) >= this.nisabMonthlyIncome;
             },
             get zakatPenghasilanAmount() {
                 return this.isPenghasilanWajib ? Math.round(this.totalPenghasilanNet * 0.025) : 0;
             },

             get totalMaalHarta() {
                 return parseInt(this.savings || 0) + (parseInt(this.goldGrams || 0) * this.nisabGoldPrice);
             },
             get isMaalWajib() {
                 return this.totalMaalHarta >= this.nisabAnnualMaal;
             },
             get zakatMaalAmount() {
                 return this.isMaalWajib ? Math.round(this.totalMaalHarta * 0.025) : 0;
             },

             get zakatFitrahAmount() {
                 return parseInt(this.fitrahCount || 1) * this.fitrahNominal;
             },

             get finalZakatTitle() {
                 if (this.type === 'penghasilan') return 'Zakat Penghasilan';
                 if (this.type === 'maal') return 'Zakat Maal (Harta)';
                 return 'Zakat Fitrah';
             },

             get finalZakatAmount() {
                 if (this.type === 'penghasilan') return this.zakatPenghasilanAmount;
                 if (this.type === 'maal') return this.zakatMaalAmount;
                 return this.zakatFitrahAmount;
             }
         }">

        <!-- HEADER TITLE -->
        <div class="space-y-1 text-center sm:text-left">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                Kalkulator Nisab & Zakat
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Kalkulator Zakat Digital</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-xl">
                Hitung kewajiban Zakat Maal, Penghasilan, dan Fitrah sesuai nisab resmi standar syariat Islam.
            </p>
        </div>

        <!-- CATEGORY SELECTOR TABS -->
        <div class="flex items-center gap-2 p-1.5 bg-slate-200/60 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
            <button @click="type = 'penghasilan'" 
                    class="flex-1 py-2.5 px-4 text-xs font-semibold rounded-lg transition-all"
                    :class="type === 'penghasilan' ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                Zakat Penghasilan
            </button>
            <button @click="type = 'maal'" 
                    class="flex-1 py-2.5 px-4 text-xs font-semibold rounded-lg transition-all"
                    :class="type === 'maal' ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                Zakat Maal / Harta
            </button>
            <button @click="type = 'fitrah'" 
                    class="flex-1 py-2.5 px-4 text-xs font-semibold rounded-lg transition-all"
                    :class="type === 'fitrah' ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                Zakat Fitrah
            </button>
        </div>

        <!-- CALCULATOR GRID: INPUTS & SUMMARY -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- LEFT COLUMN: INPUT FORM (7 COLS) -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-5">
                
                <!-- ZAKAT PENGHASILAN INPUTS -->
                <div x-show="type === 'penghasilan'" x-transition class="space-y-4">
                    <div class="space-y-1 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Simulasi Zakat Penghasilan</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Nisab bulanan: Rp {{ number_format($nisabMonthlyIncome, 0, ',', '.') }} (setara 85gr emas / 12)</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Penghasilan Utama Per Bulan (Gaji / Honor)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyIncome" class="w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pendapatan Tambahan / Bonus (Opsional)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyBonus" class="w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pengeluaran Kebutuhan Pokok Bulan Ini</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyNeeds" class="w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- ZAKAT MAAL INPUTS -->
                <div x-show="type === 'maal'" x-transition class="space-y-4">
                    <div class="space-y-1 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Simulasi Zakat Maal (Simpanan Harta)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Nisab tahunan: Rp {{ number_format($nisabAnnualMaal, 0, ',', '.') }} (85gr emas murni)</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Tabungan / Deposito / Giro (Telah Mengendap 1 Tahun)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="savings" class="w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Simpanan Emas Murni (Gram)</label>
                        <input type="number" x-model="goldGrams" placeholder="0" class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                        <p class="text-[11px] text-slate-400 font-medium">Estimasi nilai emas: Rp <span x-text="(goldGrams * nisabGoldPrice).toLocaleString('id-ID')"></span></p>
                    </div>
                </div>

                <!-- ZAKAT FITRAH INPUTS -->
                <div x-show="type === 'fitrah'" x-transition class="space-y-4">
                    <div class="space-y-1 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Simulasi Zakat Fitrah</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kewajiban per jiwa: Rp {{ number_format($fitrahNominal, 0, ',', '.') }} (setara 2.5kg beras)</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Jiwa / Anggota Keluarga yang Ditanggung</label>
                        <input type="number" x-model="fitrahCount" min="1" class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: SUMMARY RESULT CARD (5 COLS) -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-6">
                
                <div class="space-y-1 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Ringkasan Kewajiban</span>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white" x-text="finalZakatTitle"></h3>
                </div>

                <!-- NISAB STATUS BADGE & SUMMARY -->
                <div class="p-4 rounded-xl space-y-3"
                     :class="{
                         'bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800': type === 'fitrah' || (type === 'penghasilan' && isPenghasilanWajib) || (type === 'maal' && isMaalWajib),
                         'bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800': (type === 'penghasilan' && !isPenghasilanWajib) || (type === 'maal' && !isMaalWajib)
                     }">
                    
                    <template x-if="type === 'fitrah' || (type === 'penghasilan' && isPenghasilanWajib) || (type === 'maal' && isMaalWajib)">
                        <div class="space-y-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-600 text-white uppercase tracking-wider">
                                Wajib Menunaikan Zakat
                            </span>
                            <p class="text-xs text-emerald-900 dark:text-emerald-200 leading-relaxed font-medium">
                                Harta/penghasilan Anda telah memenuhi syarat nisab. Kewajiban zakat yang harus dikeluarkan (2.5%):
                            </p>
                            <div class="pt-1">
                                <span class="text-2xl font-extrabold text-emerald-700 dark:text-emerald-400 block tracking-tight"
                                      x-text="'Rp ' + (finalZakatAmount).toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </template>

                    <template x-if="(type === 'penghasilan' && !isPenghasilanWajib) || (type === 'maal' && !isMaalWajib)">
                        <div class="space-y-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-600 text-white uppercase tracking-wider">
                                Belum Mencapai Nisab
                            </span>
                            <p class="text-xs text-amber-900 dark:text-amber-200 leading-relaxed font-medium">
                                Nilai harta/penghasilan Anda belum mencapai ambang batas nisab syariat. Anda disarankan menyalurkan Infaq / Sedekah secara sukarela.
                            </p>
                        </div>
                    </template>
                </div>

                <!-- PAY CTA BUTTON -->
                <div class="pt-2">
                    <a :href="'/zakat/pay?title=' + encodeURIComponent(finalZakatTitle) + '&amount=' + finalZakatAmount" 
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors text-center">
                        Bayar {{ $finalZakatTitle ?? 'Zakat' }} Sekarang
                    </a>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
