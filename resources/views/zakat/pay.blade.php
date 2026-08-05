<?php
    $setting = \App\Models\Setting::first();
    $bankAccounts = $setting->bank_accounts ?? [
        ['bank_name' => 'Bank Syariah Indonesia (BSI)', 'account_number' => '7123-4567-89', 'account_name' => 'Baitul Maal Amil Zakat'],
        ['bank_name' => 'Bank Muamalat', 'account_number' => '124-000-5678', 'account_name' => 'Baitul Maal Amil Zakat']
    ];
    $presetTitle = request('title', 'Zakat Maal');
    $presetAmount = request('amount', '');
    $midtransJsUrl = ($isProduction ?? false) 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
?>

<x-app-layout>
    <!-- Midtrans Snap JS Script -->
    @if(!empty($clientKey))
        <script src="{{ $midtransJsUrl }}" data-client-key="{{ $clientKey }}"></script>
    @endif

    <div class="max-w-5xl mx-auto space-y-8" 
         x-data="{
             paymentTab: 'midtrans',
             imagePreview: null,
             uploadProgress: 0,
             isSubmitting: false,
             rawAmount: '{{ old('amount', $presetAmount) }}',
             displayAmount: '',

             formatAmountInput(val) {
                 let clean = (val || '').toString().replace(/\D/g, '');
                 this.rawAmount = clean;
                 this.displayAmount = clean ? new Intl.NumberFormat('id-ID').format(clean) : '';
             },

             init() {
                 if (this.rawAmount) {
                     this.formatAmountInput(this.rawAmount);
                 }
             },

             handleFileSelect(event) {
                 const file = event.target.files[0];
                 if (file) {
                     this.imagePreview = URL.createObjectURL(file);
                     this.uploadProgress = 0;
                     let interval = setInterval(() => {
                         this.uploadProgress += 20;
                         if (this.uploadProgress >= 100) clearInterval(interval);
                     }, 100);
                 }
             }
         }">

        <!-- HEADER TITLE -->
        <div class="space-y-1">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                Form Setor Zakat
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Form Pembayaran Zakat</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Pilih metode pembayaran <span class="font-semibold text-slate-700 dark:text-slate-300">Instant Online via Midtrans (QRIS/VA)</span> atau <span class="font-semibold text-slate-700 dark:text-slate-300">Transfer Bank Manual</span>.
            </p>
        </div>

        <!-- TWO-COLUMN LAYOUT -->
        <div class="grid lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: METHOD SELECTOR & INFO (5 COLS) -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- PAYMENT METHOD SELECTOR CARD -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">
                        Pilih Metode Pembayaran
                    </span>

                    <div class="grid grid-cols-2 gap-2.5">
                        <button type="button" 
                                @click="paymentTab = 'midtrans'" 
                                :class="paymentTab === 'midtrans' ? 'border-emerald-600 bg-emerald-50/50 dark:bg-emerald-950/40 text-emerald-900 dark:text-emerald-200 font-bold ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40'"
                                class="p-3.5 rounded-xl border text-xs text-center transition-all cursor-pointer">
                            <span class="block text-xs font-bold mb-0.5">Online Instant</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400">Midtrans QRIS / VA</span>
                        </button>

                        <button type="button" 
                                @click="paymentTab = 'manual'" 
                                :class="paymentTab === 'manual' ? 'border-emerald-600 bg-emerald-50/50 dark:bg-emerald-950/40 text-emerald-900 dark:text-emerald-200 font-bold ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/40'"
                                class="p-3.5 rounded-xl border text-xs text-center transition-all cursor-pointer">
                            <span class="block text-xs font-bold mb-0.5">Transfer Manual</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400">Upload Resi Transfer</span>
                        </button>
                    </div>
                </div>

                <!-- INFO CARD FOR MIDTRANS METHOD -->
                <div x-show="paymentTab === 'midtrans'" x-transition class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-2.5 shadow-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">Gateway Payment Midtrans</h4>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Anda dapat bertransaksi menggunakan <strong class="font-semibold text-slate-700 dark:text-slate-300">Dynamic QRIS, Virtual Account (BSI, Mandiri, BCA, BRI, BNI), atau E-Wallet</strong>. 
                        Status verifikasi akan diproses <strong class="font-semibold text-emerald-600 dark:text-emerald-400">secara otomatis</strong> oleh sistem secara realtime.
                    </p>
                </div>

                <!-- QRIS & BANK CARD FOR MANUAL METHOD -->
                <div x-show="paymentTab === 'manual'" x-transition class="space-y-4">
                    <!-- QRIS CARD -->
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs text-center space-y-3">
                        <span class="text-xs font-bold text-slate-900 dark:text-white block uppercase tracking-wider">QRIS Resmi Baitul Maal</span>

                        <div class="p-3 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 inline-block shadow-xs">
                            <img src="{{ !empty($setting->qris_image) ? Storage::url($setting->qris_image) : asset('qris_sample.png') }}" 
                                 alt="QRIS Baitul Maal" 
                                 class="w-64 h-64 sm:w-72 sm:h-72 object-contain mx-auto rounded-lg">
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Scan QRIS menggunakan GoPay, OVO, Dana, LinkAja, BCA Mobile, BSI Mobile, dll.</p>
                    </div>

                    <!-- BANK ACCOUNTS CARD -->
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Rekening Bank Resmi
                        </h3>

                        <div class="space-y-2.5">
                            @foreach($bankAccounts as $acc)
                                <div class="p-3.5 rounded-xl bg-slate-50/80 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-1">
                                    <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 block">{{ $acc['bank_name'] ?? 'Bank Syariah' }}</span>
                                    <div class="flex items-center justify-between">
                                        <span class="text-base font-extrabold text-slate-900 dark:text-white tracking-wide">{{ $acc['account_number'] ?? '-' }}</span>
                                        <button type="button" @click="navigator.clipboard.writeText('{{ $acc['account_number'] ?? '' }}'); window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Nomor rekening berhasil disalin!', type: 'success' } }))" class="px-2.5 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[11px] font-bold rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 transition-colors cursor-pointer">
                                            Salin
                                        </button>
                                    </div>
                                    <span class="text-[11px] text-slate-400 block">a.n. {{ $acc['account_name'] ?? 'Baitul Maal' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: PAYMENT FORM (7 COLS) -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
                
                <form method="POST" action="{{ route('zakat.pay.store') }}" enctype="multipart/form-data" @submit="isSubmitting = true" class="space-y-5">
                    @csrf
                    <input type="hidden" name="payment_method" :value="paymentTab">

                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white" x-text="paymentTab === 'midtrans' ? 'Pembayaran Instant Online (Midtrans)' : 'Konfirmasi Transfer Manual'"></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Silakan lengkapi data diri dan nominal zakat yang hendak disetorkan.</p>
                    </div>

                    <!-- Nama Pengirim -->
                    <div class="space-y-1.5">
                        <x-input-label for="sender_name" value="Nama Pengirim / Muzakki" />
                        <x-text-input id="sender_name" type="text" name="sender_name" value="{{ old('sender_name', Auth::user()->name) }}" required />
                        @error('sender_name')
                            <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Zakat -->
                    <div class="space-y-1.5">
                        <x-input-label for="title" value="Peruntukan Zakat / Infaq" />
                        <select id="title" name="title" required class="w-full border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
                            <option value="Zakat Maal" {{ $presetTitle === 'Zakat Maal (Harta)' || $presetTitle === 'Zakat Maal' ? 'selected' : '' }}>Zakat Maal (Harta)</option>
                            <option value="Zakat Penghasilan" {{ $presetTitle === 'Zakat Penghasilan' ? 'selected' : '' }}>Zakat Penghasilan (Profesi)</option>
                            <option value="Zakat Fitrah" {{ $presetTitle === 'Zakat Fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                            <option value="Infaq / Sedekah" {{ $presetTitle === 'Infaq / Sedekah' ? 'selected' : '' }}>Infaq & Sedekah</option>
                        </select>
                        @error('title')
                            <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nominal Pembayaran -->
                    <div class="space-y-1.5">
                        <x-input-label for="amount_display" value="Nominal Pembayaran (Rp)" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                            <input type="hidden" name="amount" :value="rawAmount">
                            <input id="amount_display" 
                                   type="text" 
                                   x-model="displayAmount" 
                                   @input="formatAmountInput($event.target.value)" 
                                   required 
                                   placeholder="Contoh: 250.000" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 font-bold tracking-tight transition-colors">
                        </div>
                        @error('amount')
                            <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Keterangan Tambahan -->
                    <div class="space-y-1.5">
                        <x-input-label for="notes" value="Catatan / Doa Niat Zakat (Opsional)" />
                        <textarea id="notes" name="notes" rows="2" placeholder="Tuliskan catatan khusus atau niat doa..." class="w-full border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">{{ old('notes') }}</textarea>
                    </div>

                    <!-- UPLOAD BUKTI TRANSFER (Hanya Muncul Jika Metode Manual) -->
                    <div x-show="paymentTab === 'manual'" x-transition class="space-y-2">
                        <x-input-label value="Upload Foto Resi / Bukti Transfer" />
                        
                        <div class="border border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-5 text-center hover:border-emerald-600 transition-colors bg-slate-50/50 dark:bg-slate-950 relative">
                            <input type="file" name="proof_image" accept="image/*" :required="paymentTab === 'manual'" @change="handleFileSelect" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <template x-if="!imagePreview">
                                <div class="space-y-1 pointer-events-none">
                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Klik untuk memilih file bukti transfer</p>
                                    <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP (Maksimal 5MB)</p>
                                </div>
                            </template>

                            <template x-if="imagePreview">
                                <div class="space-y-2">
                                    <img :src="imagePreview" alt="Preview Resi" class="max-h-40 rounded-lg mx-auto border border-slate-200 dark:border-slate-800 object-contain">
                                    <p class="text-xs font-semibold text-emerald-600">Foto Terpilih</p>
                                </div>
                            </template>
                        </div>

                        <!-- Progress Bar -->
                        <div x-show="uploadProgress > 0" x-transition class="space-y-1">
                            <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-600 h-1.5 transition-all duration-300" :style="'width: ' + uploadProgress + '%'"></div>
                            </div>
                        </div>

                        @error('proof_image')
                            <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="pt-2">
                        <button type="submit" :disabled="isSubmitting" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 cursor-pointer">
                            <template x-if="!isSubmitting">
                                <span x-text="paymentTab === 'midtrans' ? 'Lanjutkan Pembayaran Online (Midtrans)' : 'Kirim Bukti Pembayaran Manual'"></span>
                            </template>
                            <template x-if="isSubmitting">
                                <span>Memproses Pembayaran...</span>
                            </template>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</x-app-layout>
