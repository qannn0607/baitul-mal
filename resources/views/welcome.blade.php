<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', activeNews: null, activeTab: 'semua' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baitul Maal - Portal Resmi Lembaga Amil Zakat Republik Indonesia</title>

    <!-- Favicon & Icon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('storage/baitul_mal.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('storage/baitul_mal.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/baitul_mal.jpg') }}">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">

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
        
        .running-text {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-slate-800 selection:text-white transition-colors duration-200">

    <!-- TOPBAR PORTAL PEMERINTAHAN (GOVERNMENT OFFICIAL HEADER BAR) -->
    <div class="bg-slate-900 text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2">
            <!-- Left: Flag & Official Government Portal Identity -->
            <div class="flex items-center gap-3 text-[11px] font-semibold text-slate-300">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-red-700 text-white font-bold rounded text-[10px]">
                    INDONESIA
                </span>
                <span>PORTAL RESMI LEMBAGA AMIL ZAKAT (LAZ) REPUBLIK INDONESIA</span>
            </div>

            <!-- Right: Contact, Date & Accessibility -->
            <div class="flex items-center gap-4 text-[11px] font-medium text-slate-300">
                <span class="hidden sm:inline-block">Layanan Pengaduan: 159 / WhatsApp: 0812-3456-7890</span>
                <span class="hidden md:inline-block text-slate-700">|</span>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-1 text-slate-300 hover:text-white transition-colors">
                    <template x-if="darkMode">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                </button>
            </div>
        </div>
    </div>

    <!-- PENGUMUMAN MARQUEE TICKER INSTANSI -->
    <div class="bg-slate-800 text-slate-100 text-xs py-1.5 px-4 font-medium border-b border-slate-700 overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center gap-3">
            <span class="px-2.5 py-0.5 bg-red-700 text-white text-[10px] font-black uppercase tracking-wider flex-shrink-0 rounded">SIARAN PERS</span>
            <div class="overflow-hidden relative w-full">
                <div class="running-text text-[11px]">
                    SIARAN PERS RESMI AMIL ZAKAT: Penetapan Standar Nisab Zakat Maal Tahun 2026 Sebesar Rp 1.400.000 / Gram Emas. Pembayaran Zakat, Infak, dan Sedekah Dapat Dilakukan Secara Digital Melalui Midtrans QRIS. Penyaluran Periode Berjalan 8 Asnaf Terlaksana Secara Akuntabel.
                </div>
            </div>
        </div>
    </div>

    <!-- KOP HEADER INSTANSI GOVERNMENT STYLE -->
    <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Logo & Title -->
            <a href="/" class="flex items-center gap-4 group">
                <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-16 w-auto rounded-lg object-contain border border-slate-200 shadow-xs" alt="Logo Lembaga" />
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200 text-[10px] font-extrabold rounded border border-slate-300 dark:border-slate-700">SK KEMENAG RI NO. 842/2025</span>
                        <span class="text-[10px] font-bold text-slate-500">TERAKREDITASI A</span>
                    </div>
                    <h1 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white tracking-tight leading-none uppercase mt-1">
                        LEMBAGA AMIL ZAKAT BAITUL MAAL
                    </h1>
                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mt-0.5">
                        Portal Resmi Pengelolaan Zakat, Infak, Sedekah & Transparansi Penyaluran 8 Asnaf
                    </p>
                </div>
            </a>

            <!-- Actions & Auth Buttons -->
            <div class="flex items-center gap-2.5">
                <a href="{{ route('mustahik.apply') }}" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-950 text-white font-bold text-xs rounded-lg shadow-sm transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Ajukan Bantuan Mustahik</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Dashboard Aplikasi
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs border border-slate-300 dark:border-slate-700 rounded-lg transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Daftar Akun
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- NAVIGATION MENU BAR (PEMERINTAHAN) -->
    <nav class="bg-slate-900 text-white sticky top-0 z-40 border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-12 text-xs font-bold uppercase tracking-wider overflow-x-auto whitespace-nowrap">
            <div class="flex items-center gap-6">
                <a href="#beranda" class="hover:text-amber-400 py-3 border-b-2 border-amber-400">Beranda</a>
                <a href="#berita" class="hover:text-amber-400 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Berita & Siaran Pers</a>
                <a href="#layanan" class="hover:text-amber-400 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Layanan Publik Digital</a>
                <a href="#asnaf" class="hover:text-amber-400 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Transparansi 8 Asnaf</a>
                <a href="{{ route('reports.financial.print') }}" target="_blank" class="hover:text-amber-400 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Cetak Laporan Keuangan (PDF)</a>
                <a href="#faq" class="hover:text-amber-400 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">PPID & FAQ</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION / HIGHLIGHT BERITA UTAMA & LAYANAN PUBLIK (KOMDIGI & MEDAN.GO.ID STYLE) -->
    <section id="beranda" class="py-8 bg-slate-200/80 dark:bg-slate-900/80 border-b border-slate-300 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left: Main Banner Slide / Announcement Carousel -->
                <div class="lg:col-span-8 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                    <div class="relative bg-slate-950 p-8 sm:p-10 text-white min-h-[340px] flex flex-col justify-end">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent z-10"></div>
                        <img src="{{ asset('storage/baitul_mal.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-15 filter blur-xs" alt="Hero Banner Background">
                        
                        <div class="relative z-20 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-red-700 text-white font-black text-[10px] uppercase rounded">SIARAN PERS UTAMA</span>
                                <span class="text-slate-300 text-xs font-semibold">05 Agustus 2026</span>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight tracking-tight">
                                Akuntabilitas Pengelolaan Zakat: Penyaluran Bantuan Modal Usaha & Beasiswa Tahfidz Bagi Mustahik
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                                Baitul Maal selaku Lembaga Amil Zakat Resmi secara transparan mempublikasikan mutasi kas dan pendistribusian dana zakat terhimpun kepada 8 golongan Asnaf penerima zakat.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs font-bold">
                        <span class="text-slate-600 dark:text-slate-400">Verifikasi Transaksi Automatic Callback Midtrans Snap</span>
                        <a href="{{ route('zakat.pay') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white rounded-lg transition-colors">
                            Bayar Zakat Online →
                        </a>
                    </div>
                </div>

                <!-- Right: Quick Access Pintu Layanan Publik (Single Window Portal) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider mb-4 pb-2 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <span>Pintu Masuk Layanan Publik</span>
                            <span class="w-2 h-2 bg-red-700 rounded-full"></span>
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('zakat.calculator') }}" class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        01
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-slate-900">E-Kalkulator Zakat</h4>
                                        <p class="text-[10px] text-slate-500">Hitung Standar Nisab Maal & Fitrah</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-slate-900">→</span>
                            </a>

                            <a href="{{ route('zakat.pay') }}" class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        02
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-slate-900">E-Pembayaran QRIS</h4>
                                        <p class="text-[10px] text-slate-500">Setor Zakat Midtrans Callback</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-slate-900">→</span>
                            </a>

                            <a href="{{ route('mustahik.apply') }}" class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        03
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-slate-900">E-Layanan Mustahik</h4>
                                        <p class="text-[10px] text-slate-500">Pengajuan Permohonan Bantuan</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-slate-900">→</span>
                            </a>

                            <a href="{{ route('reports.financial.print') }}" target="_blank" class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        04
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-slate-900">Dokumen PDF Laporan</h4>
                                        <p class="text-[10px] text-slate-500">Cetak Laporan Keuangan Kedinasan</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-slate-900">→</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- REAL-TIME STATISTIK PENGELOLAAN DANA ZAKAT -->
    <section class="py-12 bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8 space-y-2">
                <span class="px-3 py-1 bg-slate-800 text-slate-200 text-[10px] font-bold uppercase tracking-widest rounded border border-slate-700">INDIKATOR REAL-TIME MUTASI KAS</span>
                <h3 class="text-2xl font-extrabold text-white uppercase tracking-tight">Statistik Pengumpulan & Penyaluran Zakat</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-slate-800/90 p-6 rounded-xl border border-slate-700 text-center space-y-2">
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Total Zakat Terhimpun</p>
                    <p class="text-2xl sm:text-3xl font-black text-amber-400">
                        Rp {{ number_format($totalCollected ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400">Penerimaan Sah dari Muzakki</p>
                </div>

                <!-- Stat 2 -->
                <div class="bg-slate-800/90 p-6 rounded-xl border border-slate-700 text-center space-y-2">
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Total Penyaluran (8 Asnaf)</p>
                    <p class="text-2xl sm:text-3xl font-black text-emerald-400">
                        Rp {{ number_format($totalDistributed ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400">Disalurkan Kepada Mustahik</p>
                </div>

                <!-- Stat 3 -->
                <div class="bg-slate-800/90 p-6 rounded-xl border border-slate-700 text-center space-y-2">
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Sisa Saldo Kas Aktif</p>
                    <p class="text-2xl sm:text-3xl font-black text-white">
                        Rp {{ number_format($currentBalance ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400">Buku Kas Zakat Terverifikasi</p>
                </div>

                <!-- Stat 4 -->
                <div class="bg-slate-800/90 p-6 rounded-xl border border-slate-700 text-center space-y-2">
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Mustahik Penerima Manfaat</p>
                    <p class="text-2xl sm:text-3xl font-black text-amber-400">
                        {{ $mustahikCount ?? 0 }} <span class="text-xs text-slate-300 font-normal">Penerima</span>
                    </p>
                    <p class="text-[10px] text-slate-400">Terverifikasi SKTM / KTP</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION BERITA & SIARAN PERS RESMI (KOMDIGI STYLE) -->
    <section id="berita" class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-4 border-b border-slate-200 dark:border-slate-800 gap-4">
                <div>
                    <span class="text-xs font-bold text-red-700 dark:text-red-400 uppercase tracking-widest">PUBLIKASI KEDINASAN</span>
                    <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white uppercase tracking-tight mt-1">Berita & Siaran Pers Amil Zakat</h3>
                </div>
                <p class="text-xs text-slate-500 max-w-md">
                    Warta resmi dan berita pendistribusian dana zakat, infak, dan sedekah secara transparan kepada 8 golongan Mustahik.
                </p>
            </div>

            <!-- News Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- News Item 1 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="px-2.5 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold rounded">Fisabilillah</span>
                            <span class="text-slate-500">04 Agustus 2026</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                            Penyaluran Beasiswa Santri Penghafal Al-Qur'an Tahfidz Rumah Syuhada
                        </h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Baitul Maal secara resmi menyerahkan bantuan beasiswa pendidikan dan SPP bulanan kepada santri dhuafa kategori Fisabilillah.
                        </p>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Penyaluran Beasiswa Santri Penghafal Al-Qur\'an Tahfidz Rumah Syuhada', category: 'Fisabilillah', date: '04 Agustus 2026', content: 'Baitul Maal secara resmi menyerahkan dana zakat sektor Fisabilillah sebesar Rp 750.000 kepada Santri Rumah Tahfidz Syuhada. Program ini ditujukan untuk membiayai kebutuhan pendidikan, kitab, serta fasilitas hafalan Al-Qur\'an bagi santri dari keluarga dhuafa.' }" class="text-xs font-bold text-slate-900 dark:text-white hover:underline">
                            Baca Siaran Pers →
                        </button>
                    </div>
                </article>

                <!-- News Item 2 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="px-2.5 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold rounded">Miskin</span>
                            <span class="text-slate-500">03 Agustus 2026</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                            Tanggap Darurat Bantuan Pengobatan Rawat Inap Bapak Supardi
                        </h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Penyaluran zakat sektor kesehatan berupa tanggap darurat biaya rumah sakit untuk penanganan medis warga dhuafa.
                        </p>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Tanggap Darurat Bantuan Pengobatan Rawat Inap Bapak Supardi', category: 'Miskin', date: '03 Agustus 2026', content: 'Melalui verifikasi tim lapangan Amil Zakat, dana zakat kategori Miskin sebesar Rp 400.000 disalurkan secara langsung untuk melunasi biaya pengobatan medis darurat Bapak Supardi di rumah sakit setempat.' }" class="text-xs font-bold text-slate-900 dark:text-white hover:underline">
                            Baca Siaran Pers →
                        </button>
                    </div>
                </article>

                <!-- News Item 3 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="px-2.5 py-0.5 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold rounded">Fakir</span>
                            <span class="text-slate-500">01 Agustus 2026</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                            Distribusi Paket Pangan Sembako Dhuafa Keluarga Ibu Maryam
                        </h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Program pemenuhan kebutuhan pangan pokok beras, minyak, dan bantuan tunai langsung bagi keluarga tidak mampu.
                        </p>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Distribusi Paket Pangan Sembako Dhuafa Keluarga Ibu Maryam', category: 'Fakir', date: '01 Agustus 2026', content: 'Baitul Maal mendistribusikan bantuan paket sembako bahan pokok pangan dan bantuan tunai sebesar Rp 500.000 kepada keluarga Ibu Maryam (kategori Fakir). Penyaluran ini bertujuan menjaga ketahanan pangan keluarga tidak mampu.' }" class="text-xs font-bold text-slate-900 dark:text-white hover:underline">
                            Baca Siaran Pers →
                        </button>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- SECTION TRANSPARANSI 8 ASNAF MUSTAHIK -->
    <section id="asnaf" class="py-14 bg-slate-100 dark:bg-slate-950 border-b border-slate-300 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-2">
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">KETENTUAN HUKUM SYARIAT</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Pedoman Penyaluran 8 Golongan Asnaf
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Berdasarkan Surah At-Taubah ayat 60, dana zakat terhimpun disalurkan secara terbuka dan akuntabel hanya kepada 8 kriteria penerima yang berhak.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $asnafList = [
                        ['title' => 'FAKIR', 'desc' => 'Masyarakat sangat miskin yang tidak memiliki harta dan tidak mempunyai pekerjaan tetap untuk memenuhi kebutuhan pokok dasar.'],
                        ['title' => 'MISKIN', 'desc' => 'Memiliki penghasilan atau pekerjaan, tetapi tidak mencukupi untuk memenuhi kebutuhan hidup dasar sehari-hari.'],
                        ['title' => 'AMIL', 'desc' => 'Petugas profesional yang diangkat resmi untuk mengumpulkan, mengelola, dan mendistribusikan dana zakat secara amanah.'],
                        ['title' => 'MUALLAF', 'desc' => 'Orang yang baru memeluk agama Islam yang membutuhkan penguatan iman dan dorongan solidaritas sosial.'],
                        ['title' => 'RIQAB', 'desc' => 'Usaha pembebasan hamba sahaya, perbudakan, serta perlindungan hak asasi kemanusiaan kaum terindas.'],
                        ['title' => 'GHARIM', 'desc' => 'Orang yang memiliki tunggakan hutang untuk mempertahankan kebutuhan pokok hidup bukan untuk maksiat.'],
                        ['title' => 'FISABILILLAH', 'desc' => 'Pejuang di jalan Allah meliputi program pendidikan santri, kegiatan dakwah, dan pembangunan sarana ibadah.'],
                        ['title' => 'IBNU SABIL', 'desc' => 'Musafir atau orang dalam perjalanan yang kehabisan bekal untuk melanjutkan perjalanan kebaikan.'],
                    ];
                @endphp

                @foreach($asnafList as $a)
                    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-6 rounded-2xl shadow-xs">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 bg-slate-900 text-white font-extrabold text-xs rounded">
                                {{ $a['title'] }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">QS. At-Taubah: 60</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $a['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION FAQ & INFORMASI PPID -->
    <section id="faq" class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">INFORMASI PUBLIK (PPID)</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mt-1">Pertanyaan Umum (FAQ)</h3>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                <div class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-xs">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Bagaimana standar nisab perhitungan Zakat Maal & Penghasilan?</span>
                        <span x-text="openFaq === 1 ? '−' : '+'" class="text-slate-900 dark:text-white font-black text-base"></span>
                    </button>
                    <div x-show="openFaq === 1" class="p-4 bg-white dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 leading-relaxed">
                        Nisab Zakat Maal adalah setara 85 gram emas murni per tahun. Jika harta simpanan telah mengendap 1 tahun dan mencapai ambang batas nisab, wajib menunaikan zakat sebesar 2,5%.
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl overflow-hidden shadow-xs">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Apakah transaksi zakat via Midtrans QRIS otomatis terverifikasi?</span>
                        <span x-text="openFaq === 2 ? '−' : '+'" class="text-slate-900 dark:text-white font-black text-base"></span>
                    </button>
                    <div x-show="openFaq === 2" class="p-4 bg-white dark:bg-slate-900 text-xs text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 leading-relaxed">
                        Ya, sistem terhubung langsung dengan Webhook Callback Midtrans secara real-time yang otomatis mencatat mutasi uang masuk pada Buku Kas Zakat.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL NEWS VIEWER -->
    <div x-show="activeNews !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click="activeNews = null" class="fixed inset-0 bg-slate-950/70"></div>
        <div class="relative bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-6 sm:p-8 max-w-lg w-full shadow-2xl z-10 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <span class="px-2.5 py-1 bg-slate-800 text-white font-bold text-xs rounded" x-text="activeNews?.category"></span>
                <span class="text-xs text-slate-500" x-text="activeNews?.date"></span>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white" x-text="activeNews?.title"></h3>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed" x-text="activeNews?.content"></p>
            <div class="pt-4 flex justify-end">
                <button @click="activeNews = null" class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-lg hover:bg-black transition-colors">
                    Tutup Siaran Pers
                </button>
            </div>
        </div>
    </div>

    <!-- FOOTER RESMI PORTAL PEMERINTAHAN (GO.ID STYLE) -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-slate-800 text-xs">
                <!-- Col 1: Profil Lembaga -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-10 w-auto rounded object-contain" alt="Logo Footer" />
                        <div>
                            <h4 class="font-black text-sm text-white uppercase tracking-wider">BAITUL MAAL</h4>
                            <p class="text-[10px] text-slate-400 font-bold">Lembaga Amil Zakat Resmi</p>
                        </div>
                    </div>
                    <p class="text-slate-400 leading-relaxed">
                        Sistem informasi pengelolaan zakat, infak, dan sedekah terintegrasi dengan pencatatan akuntansi ganda dan verifikasi otomatis.
                    </p>
                    <p class="text-amber-400 font-bold text-[11px]">
                        Izin SK Kemenag RI No. 842/2025
                    </p>
                </div>

                <!-- Col 2: Tautan Layanan Digital -->
                <div>
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Layanan Digital</h5>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="{{ route('zakat.calculator') }}" class="hover:text-white transition-colors">E-Kalkulator Zakat</a></li>
                        <li><a href="{{ route('zakat.pay') }}" class="hover:text-white transition-colors">E-Pembayaran QRIS</a></li>
                        <li><a href="{{ route('mustahik.apply') }}" class="hover:text-white transition-colors">E-Layanan Mustahik</a></li>
                        <li><a href="{{ route('reports.financial.print') }}" target="_blank" class="hover:text-white transition-colors">Cetak Laporan PDF</a></li>
                    </ul>
                </div>

                <!-- Col 3: Tautan Instansi Terkait -->
                <div>
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Instansi Terkait</h5>
                    <ul class="space-y-2 text-slate-400">
                        <li>Kementerian Agama RI (kemenag.go.id)</li>
                        <li>BAZNAS RI (baznas.go.id)</li>
                        <li>Majelis Ulama Indonesia (mui.or.id)</li>
                        <li>Kementerian Komunikasi dan Digital</li>
                    </ul>
                </div>

                <!-- Col 4: Pengaduan & Alamat -->
                <div class="space-y-2">
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Kantor Pusat</h5>
                    <p class="text-slate-400">Gedung Pusat Baitul Maal, Jl. Kebajikan No. 99, Jakarta Pusat 10110</p>
                    <p class="text-slate-400">Call Center: 159 / (021) 8000-ZAKAT</p>
                    <p class="text-slate-400">Email: layanan@baitulmaal.go.id</p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} Lembaga Amil Zakat Baitul Maal - Republik Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="font-semibold text-slate-400">Portal Resmi Pengelolaan Zakat Digital</p>
            </div>

        </div>
    </footer>

</body>
</html>
