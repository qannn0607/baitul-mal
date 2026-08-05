<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', activeNews: null }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baitul Maal - Portal Resmi Lembaga Amil Zakat & Transparansi 8 Asnaf</title>

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
        
        .running-text {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 25s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased selection:bg-emerald-700 selection:text-white transition-colors duration-200">

    <!-- TOPBAR OFFICIAL GOV ANNOUNCEMENT & CONTACT -->
    <div class="bg-emerald-900 text-white text-xs py-2 px-4 border-b border-emerald-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2">
            <!-- Left: Contact & Operating Hours -->
            <div class="flex items-center gap-4 text-[11px] font-medium text-emerald-100">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                    Hotline Muzakki: (021) 8000-ZAKAT / 0812-3456-7890
                </span>
                <span class="hidden sm:inline-block text-emerald-700">|</span>
                <span class="hidden sm:inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Jam Operasional: Sen - Jum (08:00 - 16:00 WIB)
                </span>
            </div>

            <!-- Right: Dark mode & Portal Status -->
            <div class="flex items-center gap-3">
                <span class="px-2 py-0.5 bg-emerald-800 text-emerald-200 text-[10px] font-bold rounded uppercase tracking-wider">SK KEMENAG RI NO. 842/2025</span>
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-1 text-emerald-200 hover:text-white transition-colors">
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

    <!-- PENGUMUMAN MARQUEE TICKER -->
    <div class="bg-amber-500 text-slate-950 text-xs py-1.5 px-4 font-bold overflow-hidden border-b border-amber-600">
        <div class="max-w-7xl mx-auto flex items-center gap-3">
            <span class="px-2 py-0.5 bg-slate-900 text-white text-[10px] uppercase font-black tracking-wider flex-shrink-0">PENGUMUMAN RESMI</span>
            <div class="overflow-hidden relative w-full">
                <div class="running-text text-[11px] font-semibold tracking-wide">
                    PENGUMUMAN RESMI AMIL ZAKAT: Penetapan Nisab Zakat Maal Tahun 2026 Sebesar Rp 1.400.000 / Gram Emas. Salurkan Zakat, Infak, dan Sedekah Anda Melalui Rekening & QRIS Midtrans Resmi Baitul Maal. Penyaluran Periode Berjalan 8 Asnaf Terlaksana Secara Transparan & Real-Time.
                </div>
            </div>
        </div>
    </div>

    <!-- KOP HEADER INSTANSI RESMI -->
    <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Kop Logo & Title -->
            <a href="/" class="flex items-center gap-4 group">
                <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-14 w-auto rounded-xl object-contain border border-slate-200 shadow-sm group-hover:scale-105 transition-transform" alt="Baitul Maal Logo" />
                <div>
                    <h1 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white tracking-tight leading-none uppercase">
                        LEMBAGA AMIL ZAKAT BAITUL MAAL
                    </h1>
                    <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mt-1">
                        Portal Resmi Pengelolaan Zakat, Infak, Sedekah & Transparansi 8 Asnaf
                    </p>
                </div>
            </a>

            <!-- Portal Auth Action Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('mustahik.apply') }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Ajukan Bantuan Mustahik</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Dashboard Aplikasi
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 font-bold text-xs border border-slate-300 dark:border-slate-700 rounded-lg transition-colors">
                        Masuk User / Admin
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- NAVIGATION MENU BAR -->
    <nav class="bg-emerald-800 dark:bg-emerald-950 text-white sticky top-0 z-40 border-b border-emerald-900 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-12 text-xs font-bold uppercase tracking-wider overflow-x-auto">
            <div class="flex items-center gap-6 whitespace-nowrap">
                <a href="#beranda" class="hover:text-amber-300 py-3 border-b-2 border-amber-400">Beranda</a>
                <a href="#berita" class="hover:text-amber-300 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Kabar & Berita Penyaluran</a>
                <a href="#layanan" class="hover:text-amber-300 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Layanan Zakat</a>
                <a href="#asnaf" class="hover:text-amber-300 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Transparansi 8 Asnaf</a>
                <a href="#laporan" class="hover:text-amber-300 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">Laporan Keuangan PDF</a>
                <a href="#faq" class="hover:text-amber-300 py-3 border-b-2 border-transparent hover:border-amber-400 transition-colors">FAQ & Konsultasi</a>
            </div>
            <div class="hidden lg:flex items-center gap-2 text-[11px] text-emerald-200">
                <span>Status Midtrans QRIS: <strong class="text-emerald-300">ONLINE</strong></span>
            </div>
        </div>
    </nav>

    <!-- MAIN HERO / FEATURED NEWS & QUICK ACCESS PORTAL -->
    <section id="beranda" class="py-8 bg-slate-200/60 dark:bg-slate-900/60 border-b border-slate-300 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left: Featured Banner / News Slide -->
                <div class="lg:col-span-8 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl overflow-hidden shadow-md flex flex-col justify-between">
                    <div class="relative bg-emerald-950 p-8 sm:p-10 text-white min-h-[320px] flex flex-col justify-end">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/70 to-transparent z-10"></div>
                        <img src="{{ asset('storage/baitul_mal.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 filter blur-xs" alt="Background Header">
                        
                        <div class="relative z-20 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-amber-500 text-slate-950 font-black text-[10px] uppercase rounded tracking-wider">LIPUTAN UTAMA</span>
                                <span class="text-emerald-300 text-xs font-semibold">Agustus 2026</span>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight tracking-tight">
                                Penyaluran Dana Zakat Periode Berjalan: Bantuan Modal Usaha & Paket Sembako Bagi 8 Asnaf
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-200 max-w-2xl leading-relaxed">
                                Baitul Maal telah menyalurkan dana zakat terhimpun secara akuntabel kepada kaum dhuafa, fakir miskin, dan program beasiswa santri tahfidz dengan pengawasan syariat.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs font-bold">
                        <span class="text-slate-600 dark:text-slate-400">Verifikasi Transaksi Automatic Callback Midtrans Snap</span>
                        <a href="{{ route('zakat.pay') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg shadow-sm transition-colors">
                            Bayar Zakat Online Seketika →
                        </a>
                    </div>
                </div>

                <!-- Right: Quick Access Widget Menu (Layanan Cepat Instansi) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-6 shadow-md">
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider mb-4 pb-2 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <span>Layanan Cepat Muzakki</span>
                            <span class="w-2 h-2 bg-emerald-600 rounded-full"></span>
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('zakat.calculator') }}" class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-700 text-white flex items-center justify-center font-bold text-xs">
                                        01
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-700">Kalkulator Zakat</h4>
                                        <p class="text-[10px] text-slate-500">Hitung nisab Maal & Fitrah</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-emerald-700">→</span>
                            </a>

                            <a href="{{ route('zakat.pay') }}" class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-700 text-white flex items-center justify-center font-bold text-xs">
                                        02
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-700">Bayar Zakat Online</h4>
                                        <p class="text-[10px] text-slate-500">QRIS, Transfer Bank, Midtrans</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-emerald-700">→</span>
                            </a>

                            <a href="{{ route('mustahik.apply') }}" class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/80 hover:bg-amber-50 dark:hover:bg-amber-950/40 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center font-bold text-xs">
                                        03
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-amber-700">Layanan Mustahik</h4>
                                        <p class="text-[10px] text-slate-500">Pengajuan bantuan & SKTM</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-amber-700">→</span>
                            </a>

                            <a href="{{ route('reports.financial.print') }}" target="_blank" class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/80 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 border border-slate-200 dark:border-slate-700 rounded-xl transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                        04
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-700">Laporan PDF Keuangan</h4>
                                        <p class="text-[10px] text-slate-500">Unduh dokumen transparansi</p>
                                    </div>
                                </div>
                                <span class="text-slate-400 group-hover:text-emerald-700">→</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- REAL-TIME STATISTIK PENGELOLAAN DANA ZAKAT -->
    <section class="py-10 bg-emerald-900 text-white border-b border-emerald-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <span class="px-3 py-1 bg-emerald-800 text-emerald-200 text-[10px] font-bold uppercase tracking-widest rounded">DATA TERKINI REAL-TIME</span>
                <h3 class="text-xl sm:text-2xl font-black text-white mt-2 uppercase">Statistik Pengumpulan & Penyaluran Zakat</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-emerald-800/80 p-6 rounded-2xl border border-emerald-700 shadow-md text-center">
                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Total Zakat Terhimpun</p>
                    <p class="text-2xl sm:text-3xl font-black text-amber-400 mt-2">
                        Rp {{ number_format($totalCollected ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-emerald-300 mt-1">Penerimaan Sah dari Muzakki</p>
                </div>

                <!-- Stat 2 -->
                <div class="bg-emerald-800/80 p-6 rounded-2xl border border-emerald-700 shadow-md text-center">
                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Total Penyaluran (8 Asnaf)</p>
                    <p class="text-2xl sm:text-3xl font-black text-emerald-300 mt-2">
                        Rp {{ number_format($totalDistributed ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-emerald-300 mt-1">Disalurkan Kepada Mustahik</p>
                </div>

                <!-- Stat 3 -->
                <div class="bg-emerald-800/80 p-6 rounded-2xl border border-emerald-700 shadow-md text-center">
                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Sisa Saldo Kas Aktif</p>
                    <p class="text-2xl sm:text-3xl font-black text-white mt-2">
                        Rp {{ number_format($currentBalance ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-emerald-300 mt-1">Buku Kas Zakat Terverifikasi</p>
                </div>

                <!-- Stat 4 -->
                <div class="bg-emerald-800/80 p-6 rounded-2xl border border-emerald-700 shadow-md text-center">
                    <p class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Mustahik Penerima Manfaat</p>
                    <p class="text-2xl sm:text-3xl font-black text-amber-400 mt-2">
                        {{ $mustahikCount ?? 0 }} <span class="text-xs text-emerald-200 font-normal">Penerima</span>
                    </p>
                    <p class="text-[10px] text-emerald-300 mt-1">Terverifikasi SKTM / KTP</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION KABAR & BERITA PENYALURAN TERKINI -->
    <section id="berita" class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-4 border-b border-slate-200 dark:border-slate-800 gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">KABAR KETAHANAN & PENYALURAN</span>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mt-1">Berita Kegiatan Lembaga Amil Zakat</h3>
                </div>
                <p class="text-xs text-slate-500 max-w-md">
                    Liputan kegiatan pendistribusian dana zakat, infak, dan sedekah secara transparan kepada 8 golongan Mustahik penerima zakat.
                </p>
            </div>

            <!-- News Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- News Item 1 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 font-bold rounded">Pendidikan (Fisabilillah)</span>
                                <span class="text-slate-500">04 Agustus 2026</span>
                            </div>
                            <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                                Penyaluran Beasiswa Santri Penghafal Al-Qur'an Tahfidz Rumah Syuhada
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Baitul Maal telah menyerahkan bantuan beasiswa pendidikan dan SPP bulanan kepada para santri dhuafa kategori Fisabilillah untuk mendukung generasi Qur'ani.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Penyaluran Beasiswa Santri Penghafal Al-Qur\'an Tahfidz Rumah Syuhada', category: 'Fisabilillah', date: '04 Agustus 2026', content: 'Baitul Maal secara resmi menyerahkan dana zakat sektor Fisabilillah sebesar Rp 750.000 kepada Santri Rumah Tahfidz Syuhada. Program ini ditujukan untuk membiayai kebutuhan pendidikan, kitab, serta fasilitas hafalan Al-Qur\'an bagi santri dari keluarga dhuafa.' }" class="text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:underline">
                            Baca Selengkapnya →
                        </button>
                    </div>
                </article>

                <!-- News Item 2 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="px-2.5 py-0.5 bg-rose-100 text-rose-800 font-bold rounded">Kesehatan (Miskin)</span>
                                <span class="text-slate-500">03 Agustus 2026</span>
                            </div>
                            <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                                Tanggap Darurat Bantuan Pengobatan Rawat Inap Bapak Supardi
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Penyaluran zakat kategori Miskin berupa bantuan tanggap darurat biaya pengobatan rumah sakit untuk penanganan medis warga dhuafa.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Tanggap Darurat Bantuan Pengobatan Rawat Inap Bapak Supardi', category: 'Miskin', date: '03 Agustus 2026', content: 'Melalui verifikasi tim lapangan Amil Zakat, dana zakat kategori Miskin sebesar Rp 400.000 disalurkan secara langsung untuk melunasi biaya pengobatan medis darurat Bapak Supardi di rumah sakit setempat.' }" class="text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:underline">
                            Baca Selengkapnya →
                        </button>
                    </div>
                </article>

                <!-- News Item 3 -->
                <article class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="p-6 space-y-3">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 font-bold rounded">Sembako (Fakir)</span>
                                <span class="text-slate-500">01 Agustus 2026</span>
                            </div>
                            <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug">
                                Distribusi Paket Pangan Sembako Dhuafa Keluarga Ibu Maryam
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Program pemenuhan kebutuhan pokok beras, minyak, dan bantuan tunai langsung bagi keluarga sangat miskin tanpa penghasilan tetap.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                        <button @click="activeNews = { title: 'Distribusi Paket Pangan Sembako Dhuafa Keluarga Ibu Maryam', category: 'Fakir', date: '01 Agustus 2026', content: 'Baitul Maal mendistribusikan bantuan paket sembako bahan pokok pangan dan bantuan tunai sebesar Rp 500.000 kepada keluarga Ibu Maryam (kategori Fakir). Penyaluran ini bertujuan menjaga ketahanan pangan keluarga tidak mampu.' }" class="text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:underline">
                            Baca Selengkapnya →
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
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">PEDOMAN SYARIAT ISLAM</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Ketentuan Penyaluran Zakat 8 Golongan Asnaf
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Berdasarkan Surah At-Taubah ayat 60, seluruh dana zakat terhimpun disalurkan secara terbatas dan terbuka hanya kepada 8 kriteria penerima yang berhak.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $asnafList = [
                        ['title' => 'FAKIR', 'desc' => 'Masyarakat sangat miskin yang tidak memiliki harta dan tidak mempunyai pekerjaan tetap untuk memenuhi kebutuhan pokok dasar.', 'color' => 'rose'],
                        ['title' => 'MISKIN', 'desc' => 'Memiliki penghasilan atau pekerjaan, tetapi tidak mencukupi untuk memenuhi kebutuhan hidup dasar sehari-hari.', 'color' => 'amber'],
                        ['title' => 'AMIL', 'desc' => 'Petugas profesional yang diangkat resmi untuk mengumpulkan, mengelola, dan mendistribusikan dana zakat secara amanah.', 'color' => 'blue'],
                        ['title' => 'MUALLAF', 'desc' => 'Orang yang baru memeluk agama Islam yang membutuhkan penguatan iman dan dorongan solidaritas sosial.', 'color' => 'emerald'],
                        ['title' => 'RIQAB', 'desc' => 'Usaha pembebasan hamba sahaya, perbudakan, serta perlindungan hak asasi kemanusiaan kaum terindas.', 'color' => 'purple'],
                        ['title' => 'GHARIM', 'desc' => 'Orang yang memiliki tunggakan hutang untuk mempertahankan kebutuhan pokok hidup bukan untuk maksiat.', 'color' => 'orange'],
                        ['title' => 'FISABILILLAH', 'desc' => 'Pejuang di jalan Allah meliputi program pendidikan santri, kegiatan dakwah, dan pembangunan sarana ibadah.', 'color' => 'teal'],
                        ['title' => 'IBNU SABIL', 'desc' => 'Musafir atau orang dalam perjalanan yang kehabisan bekal untuk melanjutkan perjalanan kebaikan.', 'color' => 'cyan'],
                    ];
                @endphp

                @foreach($asnafList as $a)
                    <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-6 rounded-2xl shadow-sm hover:border-emerald-500 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold text-xs rounded border border-emerald-300 dark:border-emerald-800">
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

    <!-- SECTION LAPORAN KEUANGAN PDF RESMI -->
    <section id="laporan" class="py-14 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-emerald-950 text-white rounded-3xl p-8 sm:p-12 border border-emerald-800 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-4 max-w-2xl text-center lg:text-left">
                    <span class="px-3 py-1 bg-amber-500 text-slate-950 font-extrabold text-[10px] uppercase tracking-widest rounded">DOKUMEN RESMI TERVERIFIKASI</span>
                    <h3 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                        Laporan Mutasi Buku Kas & Penyaluran Zakat (PDF)
                    </h3>
                    <p class="text-xs sm:text-sm text-emerald-200 leading-relaxed">
                        Unduh salinan resmi laporan keuangan akuntansi ganda (Double-Entry Ledger) lengkap dengan rincian penerimaan muzakki, alokasi 8 Asnaf, serta legalitas tanda tangan pengurus & bendahara.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <a href="{{ route('reports.financial.print') }}" target="_blank" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs rounded-xl shadow-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Cetak / Simpan PDF Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ ACCORDION -->
    <section id="faq" class="py-14 bg-slate-100 dark:bg-slate-950 border-b border-slate-300 dark:border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">INFORMASI PUBLIK</span>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mt-1">Pertanyaan Umum (FAQ)</h3>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Bagaimana cara menghitung nisab zakat Maal & Penghasilan?</span>
                        <span x-text="openFaq === 1 ? '−' : '+'" class="text-emerald-700 font-black text-base"></span>
                    </button>
                    <div x-show="openFaq === 1" class="p-4 bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 leading-relaxed">
                        Nisab Zakat Maal adalah setara dengan 85 gram emas murni. Jika harta tabungan atau investasi yang Anda miliki telah mengendap selama 1 tahun (haul) dan bernilai minimal setara nisab emas tersebut (misal Rp 1.400.000/gram = Rp 119.000.000), maka wajib menunaikan zakat sebesar 2,5%.
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Apakah pembayaran melalui Midtrans QRIS langsung diverifikasi otomatis?</span>
                        <span x-text="openFaq === 2 ? '−' : '+'" class="text-emerald-700 font-black text-base"></span>
                    </button>
                    <div x-show="openFaq === 2" class="p-4 bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 leading-relaxed">
                        Ya, sistem Baitul Maal terintegrasi langsung dengan Webhook Notification Callback Midtrans. Setelah Anda melakukan scan QRIS atau transfer bank, sistem akan memverifikasi transaksi secara real-time dan secara otomatis mencatat penerimaan uang ke Buku Kas Zakat.
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Bagaimana prosedur pengajuan bantuan bagi Mustahik?</span>
                        <span x-text="openFaq === 3 ? '−' : '+'" class="text-emerald-700 font-black text-base"></span>
                    </button>
                    <div x-show="openFaq === 3" class="p-4 bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-600 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 leading-relaxed">
                        Masyarakat yang tergolong dalam 8 Asnaf dapat mengajukan bantuan secara online melalui menu "Ajukan Bantuan Mustahik" dengan melampirkan berkas NIK KTP, deskripsi kebutuhan, serta foto Surat Keterangan Tidak Mampu (SKTM). Tim Amil Zakat akan melakukan verifikasi berkas sebelum menyalurkan dana.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MODAL NEWS DETAIL VIEWER -->
    <div x-show="activeNews !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click="activeNews = null" class="fixed inset-0 bg-slate-950/70"></div>
        <div class="relative bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-6 sm:p-8 max-w-lg w-full shadow-2xl z-10 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs rounded" x-text="activeNews?.category"></span>
                <span class="text-xs text-slate-500" x-text="activeNews?.date"></span>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white" x-text="activeNews?.title"></h3>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed" x-text="activeNews?.content"></p>
            <div class="pt-4 flex justify-end">
                <button @click="activeNews = null" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold text-xs rounded-lg hover:bg-slate-300 transition-colors">
                    Tutup Berita
                </button>
            </div>
        </div>
    </div>

    <!-- FOOTER RESMI LEMBAGA PERINTAHAN / KEMENAG / BAZNAS STYLE -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-slate-800 text-xs">
                <!-- Col 1: Profil Lembaga -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-10 w-auto rounded-lg object-contain" alt="Logo Footer" />
                        <div>
                            <h4 class="font-black text-sm text-white uppercase tracking-wider">BAITUL MAAL</h4>
                            <p class="text-[10px] text-emerald-400 font-bold">Lembaga Amil Zakat Resmi</p>
                        </div>
                    </div>
                    <p class="text-slate-400 leading-relaxed">
                        Sistem informasi pengelolaan zakat, infak, dan sedekah terintegrasi dengan pencatatan akuntansi ganda dan verifikasi pembayaran otomatis.
                    </p>
                    <p class="text-amber-400 font-bold text-[11px]">
                        Izin Operasional SK Kemenag RI No. 842/2025
                    </p>
                </div>

                <!-- Col 2: Tautan Layanan -->
                <div>
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Layanan Zakat</h5>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="{{ route('zakat.calculator') }}" class="hover:text-white transition-colors">Hitung Zakat Maal & Fitrah</a></li>
                        <li><a href="{{ route('zakat.pay') }}" class="hover:text-white transition-colors">Bayar Zakat QRIS Midtrans</a></li>
                        <li><a href="{{ route('mustahik.apply') }}" class="hover:text-white transition-colors">Pengajuan Bantuan Mustahik</a></li>
                        <li><a href="{{ route('reports.financial.print') }}" target="_blank" class="hover:text-white transition-colors">Cetak Laporan Keuangan PDF</a></li>
                    </ul>
                </div>

                <!-- Col 3: Legalitas & Panduan 8 Asnaf -->
                <div>
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Kategori 8 Asnaf</h5>
                    <ul class="space-y-1.5 text-slate-400">
                        <li>Fakir & Miskin (Bantuan Pokok & Kesehatan)</li>
                        <li>Amil (Pengelola Zakat Resmi)</li>
                        <li>Muallaf & Riqab (Penguatan Iman)</li>
                        <li>Gharim (Pelunasan Hutang Pokok)</li>
                        <li>Fisabilillah & Ibnu Sabil (Beasiswa Santri)</li>
                    </ul>
                </div>

                <!-- Col 4: Layanan Pengaduan & Alamat Kantor -->
                <div class="space-y-2">
                    <h5 class="font-extrabold text-white uppercase text-xs tracking-wider mb-3">Kantor Pusat Amil</h5>
                    <p class="text-slate-400">Gedung Pusat Baitul Maal, Jl. Zakat Utama No. 42, Jakarta Pusat, DKI Jakarta 10110</p>
                    <p class="text-slate-400">Telepon: (021) 8000-ZAKAT</p>
                    <p class="text-slate-400">Email: layanan@baitulmaal.or.id</p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} Lembaga Amil Zakat Baitul Maal. Seluruh Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="font-semibold text-slate-400">Portal Resmi Pengelolaan & Transparansi Zakat Digital</p>
            </div>

        </div>
    </footer>

</body>
</html>
