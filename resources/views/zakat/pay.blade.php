<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Pembayaran QRIS</span>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Bayar Zakat via QRIS</h1>
            <p class="text-sm text-slate-500 mt-1">Scan kode QRIS di bawah ini melalui aplikasi e-wallet (GoPay, OVO, Dana, LinkAja) atau m-Banking Anda, kemudian unggah bukti transfer.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start" x-data="{ 
            imagePreview: null,
            showZoomModal: false,
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file maksimal adalah 5 MB.');
                        event.target.value = '';
                        this.imagePreview = null;
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => { this.imagePreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            }
        }">

            <!-- LEFT COLUMN: QRIS IMAGE DISPLAY (5 cols) -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 shadow-sm border border-slate-100 text-center space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Scan Kode QRIS Resmi
                </div>

                <div class="relative group mx-auto w-full max-w-xs bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    <img src="{{ $qrisUrl }}" alt="QRIS Baitul Maal" class="w-full h-auto rounded-xl shadow-md mx-auto object-contain transition group-hover:scale-105" />
                    <button type="button" @click="showZoomModal = true" class="mt-3 w-full py-2 bg-slate-900/80 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Perbesar Gambar QRIS
                    </button>
                </div>

                <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-100 text-left text-xs text-emerald-900 space-y-1.5">
                    <p class="font-bold text-emerald-800">Petunjuk Pembayaran:</p>
                    <p>1. Buka aplikasi m-Banking atau E-Wallet pilihan Anda.</p>
                    <p>2. Pilih fitur <strong>Scan / Bayar QRIS</strong>.</p>
                    <p>3. Arahkan kamera ke gambar QRIS di atas.</p>
                    <p>4. Masukkan nominal sesuai zakat Anda dan selesaikan transaksi.</p>
                    <p>5. Simpan / Screenshot bukti transfer dan upload di form sebelah kanan.</p>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORM PEMBAYARAN (7 cols) -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-900 border-b pb-3 mb-6">Form Konfirmasi Pembayaran</h2>

                <form method="POST" action="{{ route('zakat.pay.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Nama Pengirim -->
                    <div>
                        <label for="sender_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pengirim</label>
                        <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name', $user->name) }}" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold" placeholder="Nama pemilik rekening / e-wallet" />
                        @error('sender_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Judul / Untuk Apa -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul / Peruntukan Zakat</label>
                        <select id="title" name="title" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold">
                            <option value="Zakat Maal" {{ old('title', $prefilledTitle) == 'Zakat Maal' ? 'selected' : '' }}>Zakat Maal (Harta/Tabungan)</option>
                            <option value="Zakat Penghasilan" {{ old('title', $prefilledTitle) == 'Zakat Penghasilan' ? 'selected' : '' }}>Zakat Penghasilan (Gaji/Bulan)</option>
                            <option value="Zakat Fitrah" {{ old('title', $prefilledTitle) == 'Zakat Fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                            <option value="Donasi / Infaq" {{ old('title', $prefilledTitle) == 'Donasi / Infaq' ? 'selected' : '' }}>Donasi / Infaq / Shadaqah</option>
                        </select>
                        @error('title')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominal Pembayaran -->
                    <div>
                        <label for="amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nominal Pembayaran (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold">Rp</span>
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $prefilledAmount) }}" required min="1000" class="w-full pl-12 rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-lg font-bold text-emerald-800" placeholder="100000" />
                        </div>
                        @error('amount')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Bukti Pembayaran -->
                    <div>
                        <label for="proof_image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Bukti Pembayaran (Max 5 MB)</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-200 hover:border-emerald-400 rounded-2xl transition bg-slate-50 relative">
                            <div class="space-y-2 text-center" x-show="!imagePreview">
                                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20L28 8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M28 8v12h12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-semibold text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                        <span>Pilih file gambar</span>
                                        <input id="proof_image" name="proof_image" type="file" accept="image/png, image/jpeg, image/jpg" class="sr-only" required @change="handleFileSelect($event)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-400">PNG, JPG, JPEG hingga 5MB</p>
                            </div>

                            <!-- Image Preview Window -->
                            <div x-show="imagePreview" x-cloak class="w-full text-center space-y-3">
                                <img :src="imagePreview" class="max-h-48 rounded-xl mx-auto shadow-md border border-slate-200 object-contain" alt="Preview Bukti" />
                                <div class="flex items-center justify-center gap-2">
                                    <label for="proof_image" class="text-xs font-semibold text-emerald-600 hover:underline cursor-pointer">Ganti Gambar</label>
                                    <span class="text-slate-300">|</span>
                                    <button type="button" @click="imagePreview = null; document.getElementById('proof_image').value=''" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                </div>
                            </div>
                        </div>

                        @error('proof_image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-xl shadow-emerald-600/30 transition-all duration-200 flex items-center justify-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Bukti Pembayaran
                        </button>
                    </div>

                </form>
            </div>

            <!-- QRIS ZOOM MODAL -->
            <div x-show="showZoomModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div x-show="showZoomModal" x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showZoomModal = false" class="fixed inset-0 bg-slate-900/80 backdrop-blur-xs"></div>
                <div x-show="showZoomModal" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl p-6 max-w-lg w-full shadow-2xl z-10 text-center">
                    <button @click="showZoomModal = false" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Kode QRIS Baitul Maal</h3>
                    <img src="{{ $qrisUrl }}" class="w-full max-h-96 object-contain rounded-2xl mx-auto border" alt="QRIS Large" />
                    <p class="text-xs text-slate-500 mt-4">Scan menggunakan kamera HP atau scanner aplikasi pembayaran Anda.</p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
