<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baitul Maal - Platform Zakat Digital & Transparansi 8 Asnaf</title>

    <!-- Favicon & Icon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/baitul_mal.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('storage/baitul_mal.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/baitul_mal.jpg') }}">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#059669">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-emerald-600 selection:text-white transition-colors duration-200">

    <!-- NAVIGATION HEADER -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-10 w-auto rounded-xl object-contain shadow-sm" alt="Baitul Maal Logo" />
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600 dark:text-slate-400">
                <a href="#hero" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Beranda</a>
                <a href="#transparansi" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Transparansi 8 Asnaf</a>
                <a href="#layanan" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Kategori Zakat</a>
                <a href="#faq" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">FAQ</a>
            </nav>

            <!-- Actions & Auth Buttons -->
            <div class="flex items-center gap-3">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 border border-slate-200 dark:border-slate-800 transition-colors">
                    <template x-if="darkMode">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors">
                        Dashboard Muzakki
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-2 text-slate-700 dark:text-slate-300 hover:text-emerald-600 font-semibold text-xs transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="py-16 lg:py-24 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        Platform Pengelolaan Zakat Transparan
                    </span>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight tracking-tight">
                        Tunaikan Zakat,<br>
                        <span class="text-emerald-600 dark:text-emerald-400">Amanah & Tepat Sasaran</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Baitul Maal mempermudah kalkulasi nisab dan penyaluran zakat Maal, Penghasilan, serta Fitrah dengan pertanggungjawaban terbuka 8 Asnaf secara real-time.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                        @auth
                            <a href="{{ route('zakat.calculator') }}" class="w-full sm:w-auto px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors text-center">
                                Hitung & Bayar Zakat
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors text-center">
                                Mulai Menunaikan Zakat
                            </a>
                        @endauth
                        <a href="#transparansi" class="w-full sm:w-auto px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-center">
                            Lihat Laporan Transparansi
                        </a>
                    </div>
                </div>

                <!-- Hero Feature Preview Card -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-6 sm:p-8 rounded-2xl shadow-xs space-y-5">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider block">Metode Pembayaran Resmi</span>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">QRIS & Midtrans Gateway</h3>
                            </div>
                            <span class="text-[10px] font-semibold px-2.5 py-0.5 bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 rounded-md border border-emerald-200 dark:border-emerald-800">Verified</span>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Pengelola Resmi:</span>
                                <span class="font-bold text-slate-900 dark:text-white">Baitul Maal Amil Zakat</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Acuan Nisab Emas:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">Rp 1.400.000 / gr</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Verifikasi Payment:</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700 dark:bg-sky-950 dark:text-sky-300 border border-sky-200 dark:border-sky-800">Realtime Callback</span>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-900 text-white rounded-xl flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-medium text-slate-400">Struk Digital PDF Resmi</p>
                                <p class="text-xs font-bold text-white">Langsung Diunduh Setelah Transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- TRANSPARENCY 8 ASNAF SECTION -->
    <section id="transparansi" class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border border-sky-200 dark:border-sky-800">
                    Akuntabilitas Syariat
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Transparansi Penyaluran 8 Asnaf</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Seluruh dana zakat yang terhimpun disalurkan secara terbuka sesuai panduan alokasi 8 Golongan Mustahik.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <?php
                    $asnafCategories = [
                        'Fakir' => 'Masyarakat sangat miskin tanpa penghasilan tetap.',
                        'Miskin' => 'Memiliki penghasilan namun tidak cukup untuk kebutuhan dasar.',
                        'Amil' => 'Petugas pengelola dan penyalur zakat profesional.',
                        'Muallaf' => 'Individu yang baru memeluk Islam dan membutuhkan penguatan.',
                        'Riqab' => 'Pembebasan hamba sahaya & perlindungan hak kemanusiaan.',
                        'Gharim' => 'Masyarakat yang terlilit hutang untuk kebutuhan hidup mendasar.',
                        'Fisabilillah' => 'Pejuang di jalan Allah, pendidikan santri & dakwah.',
                        'Ibnu Sabil' => 'Musafir yang kehabisan bekal dalam perjalanan kebaikan.',
                    ];
                ?>
                @foreach($asnafCategories as $name => $desc)
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $name }}</h3>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">8 Asnaf</span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- LAYANAN KATEGORI SECTION -->
    <section id="layanan" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Kategori Layanan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pilihan Jenis Zakat & Infaq</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Pilih kategori zakat sesuai dengan harta atau pendapatan yang Anda miliki.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Zakat Maal (Harta)</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Zakat simpanan tabungan, emas, atau aset produktif yang telah mengendap 1 tahun dan mencapai nisab 85 gram emas (2.5%).</p>
                    </div>
                    <a href="{{ route('zakat.calculator') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 pt-2">
                        Hitung Zakat Maal &rarr;
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Zakat Penghasilan</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Zakat pendapatan atau profesi bulanan dari gaji/honorarium yang memenuhi ambang batas nisab syariat (2.5%).</p>
                    </div>
                    <a href="{{ route('zakat.calculator') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 pt-2">
                        Hitung Zakat Profesi &rarr;
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs flex flex-col justify-between">
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Zakat Fitrah & Infaq</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Zakat penyucian jiwa per anggota keluarga serta donasi infaq sukarela untuk program bantuan kemanusiaan.</p>
                    </div>
                    <a href="{{ route('zakat.pay') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 pt-2">
                        Setor Zakat Sekarang &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-16 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center space-y-2">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pertanyaan Umum</span>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tanya Jawab Seputar Zakat Digital</h2>
            </div>

            <div class="space-y-3" x-data="{ openFaq: null }">
                
                <div class="bg-slate-50/50 dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <button @click="openFaq = (openFaq === 1 ? null : 1)" class="w-full p-5 text-left font-semibold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Bagaimana cara menghitung Nisab Zakat Maal & Penghasilan?</span>
                        <span class="text-slate-400 text-base" x-text="openFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-5 pb-5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Nisab zakat harta dan penghasilan dihitung berdasarkan harga 85 gram emas murni. Apabila total simpanan atau akumulasi pendapatan Anda telah mencapai batas nilai tersebut, maka wajib zakat sebesar 2.5%.
                    </div>
                </div>

                <div class="bg-slate-50/50 dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <button @click="openFaq = (openFaq === 2 ? null : 2)" class="w-full p-5 text-left font-semibold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Apakah pembayaran melalui QRIS dan Midtrans Gateway aman?</span>
                        <span class="text-slate-400 text-base" x-text="openFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-5 pb-5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Sangat aman. Platform Baitul Maal terintegrasi langsung dengan Midtrans Payment Gateway dan QRIS Bank Syariah. Seluruh dana disetorkan ke rekening lembaga resmi dan tersimpan dengan amanah.
                    </div>
                </div>

                <div class="bg-slate-50/50 dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <button @click="openFaq = (openFaq === 3 ? null : 3)" class="w-full p-5 text-left font-semibold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between gap-4">
                        <span>Berapa lama proses verifikasi dan penerbitan Struk PDF?</span>
                        <span class="text-slate-400 text-base" x-text="openFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-5 pb-5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Pembayaran via Midtrans Gateway diverifikasi secara instant real-time. Untuk transfer bank manual, verifikasi dilakukan oleh petugas amil zakat dalam kurun waktu 1x24 jam, setelah itu Struk Digital PDF resmi dapat diunduh.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-100 border-t border-slate-800 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-800 pb-6">
                <div class="flex items-center">
                    <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-10 w-auto rounded-xl object-contain shadow-sm" alt="Baitul Maal Logo" />
                </div>
                <p class="text-xs text-slate-400">
                    Sistem Informasi Pengelolaan & Transparansi Penyaluran Zakat
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>&copy; {{ date('Y') }} Baitul Maal Amil Zakat. Seluruh Hak Cipta Dilindungi.</p>
                <p>Platform Zakat Syariah Modern</p>
            </div>
        </div>
    </footer>

</body>
</html>
