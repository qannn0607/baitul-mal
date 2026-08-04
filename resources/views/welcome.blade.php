<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baitul Maal - Sistem Informasi Zakat Digital & Transparan</title>

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#059669">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-emerald-600 selection:text-white transition-colors duration-200">

    <!-- NAVIGATION HEADER -->
    <header class="sticky top-0 z-40 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-black text-xs">
                    BM
                </div>
                <div>
                    <span class="font-extrabold text-sm tracking-wide text-slate-900 dark:text-white block leading-none">BAITUL MAAL</span>
                    <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Sistem Zakat Digital</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600 dark:text-slate-300">
                <a href="#hero" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Beranda</a>
                <a href="#statistik" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Statistik</a>
                <a href="#cara-kerja" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Cara Kerja</a>
                <a href="#jenis-zakat" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Kategori Zakat</a>
                <a href="#faq" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">FAQ</a>
            </nav>

            <!-- Actions & Auth buttons -->
            <div class="flex items-center gap-2.5">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 border border-slate-200 dark:border-slate-800 transition-colors">
                    <template x-if="darkMode">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-slate-700 dark:text-slate-300 hover:text-emerald-600 font-bold text-xs transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="py-12 lg:py-20 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                    <span class="inline-block px-2.5 py-1 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-[11px] font-bold uppercase tracking-wider">
                        Sistem Pengelolaan Zakat Digital
                    </span>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight">
                        Tunaikan Zakat,<br>
                        <span class="text-emerald-600 dark:text-emerald-400">Mudah, Aman & Transparan</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Baitul Maal mempermudah perhitungan dan penyaluran zakat Maal, Penghasilan, dan Fitrah secara tepat sasaran kepada yang berhak.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                        @auth
                            <a href="{{ route('zakat.calculator') }}" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors text-center">
                                Hitung & Bayar Zakat
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors text-center">
                                Mulai Sekarang
                            </a>
                        @endauth
                        <a href="#cara-kerja" class="w-full sm:w-auto px-6 py-3 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-center">
                            Pelajari Cara Kerja
                        </a>
                    </div>
                </div>

                <!-- Hero Graphic Card -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 rounded-xl shadow-xs space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                            <div>
                                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Metode Pembayaran</span>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">QRIS & Transfer Bank</h3>
                            </div>
                            <span class="text-xs font-bold px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded">Resmi</span>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-950 p-3.5 rounded-lg border border-slate-200 dark:border-slate-800 space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Lembaga:</span>
                                <span class="font-bold text-slate-900 dark:text-white">Baitul Maal Amil Zakat</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Harga Nisab Emas:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">Rp 1.400.000 / gr</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Verifikasi:</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-[10px] font-bold">Otomatis & Real-time</span>
                            </div>
                        </div>

                        <div class="p-3 bg-emerald-600 text-white rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-[10px] opacity-90 font-medium">Struk Digital PDF</p>
                                <p class="text-xs font-bold">Langsung Dapat Diunduh</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- STATISTIK SECTION -->
    <section id="statistik" class="py-12 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center" 
                 x-data="{ 
                     dana: 184500000, 
                     muzakki: 1250, 
                     mustahik: 480, 
                     transaksi: 3420
                 }">
                
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Dana Terhimpun</p>
                    <h3 class="text-xl sm:text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight" x-text="'Rp ' + (dana).toLocaleString('id-ID')"></h3>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Muzakki Terdaftar</p>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight" x-text="(muzakki).toLocaleString('id-ID') + '+'"></h3>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Penerima Manfaat</p>
                    <h3 class="text-xl sm:text-2xl font-black text-teal-600 dark:text-teal-400 tracking-tight" x-text="(mustahik).toLocaleString('id-ID') + ' Jiwa'"></h3>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-1">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Transaksi Sukses</p>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight" x-text="(transaksi).toLocaleString('id-ID')"></h3>
                </div>

            </div>
        </div>
    </section>

    <!-- CARA KERJA SECTION -->
    <section id="cara-kerja" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Alur Praktis</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">4 Langkah Menunaikan Zakat</h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs">Proses transparan mulai dari kalkulasi mandiri hingga diterimanya bukti struk sah digital.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold text-sm flex items-center justify-center">1</div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Kalkulasi Zakat</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Gunakan kalkulator interaktif untuk mengecek nisab & kewajiban zakat Anda.</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold text-sm flex items-center justify-center">2</div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Transfer QRIS / Bank</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Scan QRIS resmi atau transfer ke rekening bank Baitul Maal.</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold text-sm flex items-center justify-center">3</div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Upload Bukti Transfer</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Unggah foto resi transfer melalui form berfitur live preview.</p>
                </div>

                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold text-sm flex items-center justify-center">4</div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Terima Struk PDF</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Setelah diverifikasi petugas, unduh struk digital resmi sebagai bukti sah.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- KATEGORI ZAKAT SECTION -->
    <section id="jenis-zakat" class="py-16 bg-slate-100/70 dark:bg-slate-900/60 border-y border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Kategori Layanan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Jenis Zakat & Infaq</h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs">Pilih kategori zakat sesuai harta atau pendapatan yang Anda miliki.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Zakat Maal (Harta)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Dari simpanan tabungan, emas, atau investasi yang telah mencapai nisab 85 gram emas dan haul 1 tahun (2.5%).</p>
                    </div>
                    <a href="{{ route('zakat.calculator') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline pt-2">
                        Hitung Zakat Maal &rarr;
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Zakat Penghasilan</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Dari gaji atau pendapatan profesi bulanan yang mencapai nisab setara 85 gram emas per tahun (2.5%).</p>
                    </div>
                    <a href="{{ route('zakat.calculator') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline pt-2">
                        Hitung Zakat Profesi &rarr;
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 space-y-3 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Zakat Fitrah & Infaq</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Zakat jiwa disalurkan menjelang Idul Fitri (Rp 45.000 / jiwa) serta donasi kebaikan umum untuk pemberdayaan umat.</p>
                    </div>
                    <a href="{{ route('zakat.pay') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline pt-2">
                        Bayar Sekarang &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center space-y-1">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Pertanyaan Umum</span>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Tanya Jawab Seputar Zakat</h2>
            </div>

            <div class="space-y-3" x-data="{ openFaq: null }">
                
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                    <button @click="openFaq = (openFaq === 1 ? null : 1)" class="w-full p-4 text-left font-bold text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Bagaimana cara menghitung Nisab Zakat Maal & Penghasilan?</span>
                        <span class="text-slate-400" x-text="openFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-4 pb-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Nisab zakat harta/penghasilan disepadankan dengan harga 85 gram emas murni. Jika pendapatan/harta dalam 1 tahun melebihi nilai 85 gram emas, maka wajib zakat sebesar 2,5%.
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                    <button @click="openFaq = (openFaq === 2 ? null : 2)" class="w-full p-4 text-left font-bold text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apakah pembayaran melalui QRIS dan Transfer Bank ini aman?</span>
                        <span class="text-slate-400" x-text="openFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-4 pb-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Sangat aman. Seluruh transaksi ditransfer langsung ke Rekening Resmi Baitul Maal. Setelah bukti diunggah, petugas akan memverifikasi secara langsung.
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs">
                    <button @click="openFaq = (openFaq === 3 ? null : 3)" class="w-full p-4 text-left font-bold text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Berapa lama proses verifikasi pembayaran zakat?</span>
                        <span class="text-slate-400" x-text="openFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-4 pb-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Proses verifikasi oleh petugas amil zakat biasanya memakan waktu maksimal 1x24 jam. Setelah diverifikasi, Anda dapat langsung mengunduh Struk Pembayaran PDF.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-100 border-t border-slate-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-800 pb-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-xs">
                        BM
                    </div>
                    <span class="font-extrabold text-sm text-white">BAITUL MAAL</span>
                </div>
                <p class="text-xs text-slate-400">
                    Sistem Informasi Pengelolaan & Penyaluran Zakat Digital
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2">
                <p>&copy; {{ date('Y') }} Baitul Maal Amil Zakat. Seluruh Hak Cipta Dilindungi.</p>
                <p>Aplikasi Zakat Digital</p>
            </div>
        </div>
    </footer>

</body>
</html>
