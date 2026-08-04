<?php
    $setting = \App\Models\Setting::first();
    $nisabGoldPrice = $setting->nisab_gold_price ?? 1400000;
    $nisabAnnualMaal = $nisabGoldPrice * 85;
    $nisabMonthlyIncome = $nisabAnnualMaal / 12;
    $fitrahNominal = $setting->zakat_fitrah_nominal ?? 45000;
?>

<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6" 
         x-data="{
             step: 1,
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
        <div class="space-y-1">
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Kalkulator Zakat Digital</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Hitung kewajiban Zakat Maal, Penghasilan, dan Fitrah sesuai standar syariat Islam & nisab resmi.
            </p>
        </div>

        <!-- STEP WIZARD BAR -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between max-w-xs mx-auto relative">
                <!-- Line background -->
                <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-200 dark:bg-slate-800 -translate-y-1/2 -z-0"></div>
                <div class="absolute top-1/2 left-0 h-0.5 bg-emerald-600 -translate-y-1/2 transition-all duration-200 -z-0"
                     :style="'width: ' + ((step - 1) / 2 * 100) + '%'"></div>

                <!-- Step 1 Circle -->
                <button @click="step = 1" class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                        :class="step >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                    1
                </button>

                <!-- Step 2 Circle -->
                <button @click="step = 2" class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                        :class="step >= 2 ? 'bg-emerald-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                    2
                </button>

                <!-- Step 3 Circle -->
                <button @click="step = 3" class="relative z-10 w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                        :class="step >= 3 ? 'bg-emerald-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500'">
                    3
                </button>
            </div>
            <div class="flex justify-between max-w-xs mx-auto text-[11px] font-bold text-slate-500 dark:text-slate-400 mt-2">
                <span>Pilih Jenis</span>
                <span>Isi Data</span>
                <span>Hasil & Bayar</span>
            </div>
        </div>

        <!-- STEP 1: CHOOSE TYPE -->
        <div x-show="step === 1" x-transition class="space-y-4">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Langkah 1: Pilih Kategori Zakat</h3>

            <div class="grid md:grid-cols-3 gap-4">
                <!-- Option 1: Penghasilan -->
                <div @click="type = 'penghasilan'; step = 2" 
                     class="cursor-pointer bg-white dark:bg-slate-900 p-5 rounded-xl border transition-colors space-y-2 shadow-xs hover:border-emerald-600"
                     :class="type === 'penghasilan' ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-800'">
                    <div class="space-y-0.5">
                        <h4 class="font-bold text-sm text-slate-900 dark:text-white">Zakat Penghasilan</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Dari gaji / profesi bulanan.</p>
                    </div>
                    <span class="inline-block text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Nisab ~ Rp {{ number_format($nisabMonthlyIncome, 0, ',', '.') }}/bln &rarr;</span>
                </div>

                <!-- Option 2: Maal -->
                <div @click="type = 'maal'; step = 2" 
                     class="cursor-pointer bg-white dark:bg-slate-900 p-5 rounded-xl border transition-colors space-y-2 shadow-xs hover:border-emerald-600"
                     :class="type === 'maal' ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-800'">
                    <div class="space-y-0.5">
                        <h4 class="font-bold text-sm text-slate-900 dark:text-white">Zakat Maal (Harta)</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Dari tabungan & emas 1 thn.</p>
                    </div>
                    <span class="inline-block text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Nisab ~ Rp {{ number_format($nisabAnnualMaal, 0, ',', '.') }}/thn &rarr;</span>
                </div>

                <!-- Option 3: Fitrah -->
                <div @click="type = 'fitrah'; step = 2" 
                     class="cursor-pointer bg-white dark:bg-slate-900 p-5 rounded-xl border transition-colors space-y-2 shadow-xs hover:border-emerald-600"
                     :class="type === 'fitrah' ? 'border-emerald-600 ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-800'">
                    <div class="space-y-0.5">
                        <h4 class="font-bold text-sm text-slate-900 dark:text-white">Zakat Fitrah</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Wajib Ramadan per jiwa.</p>
                    </div>
                    <span class="inline-block text-[11px] font-bold text-amber-600 dark:text-amber-400">Rp {{ number_format($fitrahNominal, 0, ',', '.') }}/jiwa &rarr;</span>
                </div>
            </div>
        </div>

        <!-- STEP 2: INPUT DATA FORM -->
        <div x-show="step === 2" x-transition class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Langkah 2: Masukkan Nominal Harta</h3>
                <button @click="step = 1" class="text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                    &larr; Ganti Kategori
                </button>
            </div>

            <!-- FORM UNTUK ZAKAT PENGHASILAN -->
            <template x-if="type === 'penghasilan'">
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Penghasilan Per Bulan (Gaji/Honor)" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyIncome" class="w-full pl-9 pr-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Bonus / Pendapatan Lain (Bila Ada)" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyBonus" class="w-full pl-9 pr-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Pengeluaran Pokok Bulan Ini" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="monthlyNeeds" class="w-full pl-9 pr-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        </div>
                    </div>
                </div>
            </template>

            <!-- FORM UNTUK ZAKAT MAAL (HARTA) -->
            <template x-if="type === 'maal'">
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Total Tabungan / Deposito / Simpanan Harta (1 Tahun)" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" x-model="savings" class="w-full pl-9 pr-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Simpanan Emas Murni (Gram)" />
                        <input type="number" x-model="goldGrams" placeholder="0" class="w-full px-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        <span class="text-[11px] text-slate-400 mt-1 block">Konversi emas = Rp <span x-text="(goldGrams * nisabGoldPrice).toLocaleString('id-ID')"></span></span>
                    </div>
                </div>
            </template>

            <!-- FORM UNTUK ZAKAT FITRAH -->
            <template x-if="type === 'fitrah'">
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Jumlah Jiwa / Anggota Keluarga" />
                        <input type="number" x-model="fitrahCount" min="1" class="w-full px-3.5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-lg text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 shadow-xs">
                        <span class="text-[11px] text-slate-400 mt-1 block">Nominal per jiwa: Rp {{ number_format($fitrahNominal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </template>

            <div class="pt-2 flex justify-between items-center">
                <button @click="step = 1" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-lg transition-colors">
                    Kembali
                </button>
                <button @click="step = 3" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                    Hitung Hasil Zakat &rarr;
                </button>
            </div>
        </div>

        <!-- STEP 3: RESULTS & BAYAR SEKARANG -->
        <div x-show="step === 3" x-transition class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-5">
            <div class="text-center space-y-1">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hasil Perhitungan Resmi</span>
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white" x-text="finalZakatTitle"></h3>
            </div>

            <!-- RESULT ALERT BOX -->
            <div class="p-5 rounded-xl space-y-3"
                 :class="{
                     'bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200': type === 'fitrah' || (type === 'penghasilan' && isPenghasilanWajib) || (type === 'maal' && isMaalWajib),
                     'bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200': (type === 'penghasilan' && !isPenghasilanWajib) || (type === 'maal' && !isMaalWajib)
                 }">

                <template x-if="type === 'fitrah' || (type === 'penghasilan' && isPenghasilanWajib) || (type === 'maal' && isMaalWajib)">
                    <div class="text-center space-y-2">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-600 text-white font-bold text-[11px] uppercase tracking-wider">
                            Wajib Menunaikan Zakat
                        </span>
                        <p class="text-xs font-medium">Harta/Penghasilan Anda telah mencapai nisab syariat. Kewajiban zakat (2.5%):</p>
                        <h2 class="text-2xl font-black text-emerald-600 dark:text-emerald-400"
                            x-text="'Rp ' + (finalZakatAmount).toLocaleString('id-ID')"></h2>
                    </div>
                </template>

                <template x-if="(type === 'penghasilan' && !isPenghasilanWajib) || (type === 'maal' && !isMaalWajib)">
                    <div class="text-center space-y-2">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-amber-600 text-white font-bold text-[11px] uppercase tracking-wider">
                            Belum Wajib Zakat (Belum Mencapai Nisab)
                        </span>
                        <p class="text-xs font-medium">
                            Pendapatan/Harta Anda belum mencapai batas minimal Nisab (Rp <span x-text="(type === 'penghasilan' ? nisabMonthlyIncome : nisabAnnualMaal).toLocaleString('id-ID')"></span>). Anda disarankan untuk menyalurkan Infaq / Sedekah secara sukarela.
                        </p>
                    </div>
                </template>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
                <button @click="step = 2" class="w-full sm:w-auto px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-lg transition-colors">
                    &larr; Ubah Input
                </button>

                <a :href="'/zakat/pay?title=' + encodeURIComponent(finalZakatTitle) + '&amount=' + finalZakatAmount" 
                   class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors text-center">
                    Bayar Sekarang &rarr;
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
