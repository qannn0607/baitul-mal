<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Baitul Mal Kota Banda Aceh - Lembaga resmi pengelola zakat, infaq, dan sedekah untuk kesejahteraan umat">
    <title>Baitul Mal Kota Banda Aceh</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts - Amiri (Arabic feel) + Lato --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hijau': {
                            50:  '#f0faf5',
                            100: '#d6f1e4',
                            200: '#aee3ca',
                            300: '#77cda8',
                            400: '#43b282',
                            500: '#229668',
                            600: '#167a54',
                            700: '#125f42',
                            800: '#0e4b34',
                            900: '#0a3426',
                        },
                        'emas': {
                            300: '#f5d88a',
                            400: '#e8c05e',
                            500: '#c9992c',
                            600: '#a07420',
                        },
                        'krem': {
                            50:  '#fdfaf4',
                            100: '#f7f0df',
                        },
                    },
                    fontFamily: {
                        'amiri': ['Amiri', 'serif'],
                        'lato': ['Lato', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Lato', sans-serif; background-color: #fdfaf4; color: #1a2e22; }

        /* Geometric Islamic pattern overlay */
        .pattern-bg {
            background-color: #0e4b34;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9992c' fill-opacity='0.08'%3E%3Cpath d='M30 0L60 30L30 60L0 30Z'/%3E%3Cpath d='M30 10L50 30L30 50L10 30Z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .pattern-light {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23229668' fill-opacity='0.05'%3E%3Cpath d='M20 0L40 20L20 40L0 20Z'/%3E%3C/g%3E%3C/svg%3E");
        }

        /* Animated border for hero CTA */
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .btn-gold {
            background: linear-gradient(90deg, #c9992c, #f5d88a, #c9992c, #e8c05e);
            background-size: 300% auto;
            animation: shimmer 4s linear infinite;
            color: #0e4b34;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        /* Counter animation */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card { animation: countUp 0.6s ease-out forwards; }

        /* Nav scroll effect via JS class */
        #navbar { transition: all 0.3s ease; }
        #navbar.scrolled { box-shadow: 0 4px 24px rgba(14,75,52,0.15); background-color: rgba(14,75,52,0.98) !important; }

        /* Program card hover */
        .program-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .program-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(14,75,52,0.18); }

        /* Arabic-style decorative divider */
        .divider-ornament::before, .divider-ornament::after {
            content: '';
            display: inline-block;
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9992c);
            vertical-align: middle;
            margin: 0 12px;
        }
        .divider-ornament::after {
            background: linear-gradient(90deg, #c9992c, transparent);
        }

        /* Fade-in on scroll */
        .fade-in { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* News card */
        .news-card { transition: box-shadow 0.2s ease; }
        .news-card:hover { box-shadow: 0 8px 32px rgba(14,75,52,0.12); }
    </style>
</head>

<body class="antialiased">

{{-- ===== NAVBAR ===== --}}
<nav id="navbar" class="fixed top-0 w-full z-50 pattern-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-emas-400 flex items-center justify-center">
                    <svg viewBox="0 0 44 44" fill="none" class="w-7 h-7" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 4C22 4 8 14 8 24C8 31.7 14.3 38 22 38C29.7 38 36 31.7 36 24C36 14 22 4 22 4Z" fill="#0e4b34"/>
                        <path d="M22 10C22 10 12 18 12 25C12 30.5 16.5 35 22 35C27.5 35 32 30.5 32 25C32 18 22 10 22 10Z" fill="#229668"/>
                        <path d="M22 17C22 17 16 22 16 26.5C16 29.5 18.7 32 22 32C25.3 32 28 29.5 28 26.5C28 22 22 17 22 17Z" fill="#c9992c"/>
                        <circle cx="22" cy="26" r="3" fill="#f5d88a"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-lato font-bold text-sm leading-tight">Baitul Mal</p>
                    <p class="text-emas-300 font-lato text-xs leading-tight">Kota Banda Aceh</p>
                </div>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="#tentang" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Tentang</a>
                <a href="#program" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Program</a>
                <a href="#statistik" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Statistik</a>
                <a href="#berita" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Berita</a>
                <a href="#kontak" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Kontak</a>
                <a href="#bayar-zakat" class="btn-gold px-5 py-2 rounded-full text-sm transition-all hover:scale-105">
                    Bayar Zakat
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <button id="menu-btn" class="md:hidden text-white p-2" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-hijau-900 px-4 pb-4">
        <a href="#tentang" class="block py-2 text-white/80 hover:text-emas-300 text-sm">Tentang</a>
        <a href="#program" class="block py-2 text-white/80 hover:text-emas-300 text-sm">Program</a>
        <a href="#statistik" class="block py-2 text-white/80 hover:text-emas-300 text-sm">Statistik</a>
        <a href="#berita" class="block py-2 text-white/80 hover:text-emas-300 text-sm">Berita</a>
        <a href="#kontak" class="block py-2 text-white/80 hover:text-emas-300 text-sm">Kontak</a>
        <a href="#bayar-zakat" class="btn-gold inline-block mt-2 px-5 py-2 rounded-full text-sm">Bayar Zakat</a>
    </div>
</nav>


{{-- ===== HERO SECTION ===== --}}
<section class="pattern-bg min-h-screen flex items-center relative overflow-hidden">
    {{-- Decorative circles --}}
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full border-2 border-emas-500/10"></div>
    <div class="absolute -top-12 -right-12 w-72 h-72 rounded-full border border-emas-500/10"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-hijau-700/30 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div>
                <p class="text-emas-400 font-amiri text-xl italic mb-3 fade-in">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                <h1 class="text-white font-playfair text-4xl md:text-5xl lg:text-6xl leading-tight mb-4 fade-in" style="animation-delay:0.1s">
                    Zakat &amp; Sedekah<br>
                    <span class="text-emas-400">untuk Umat</span>
                </h1>
                <p class="text-white/70 font-lato text-lg leading-relaxed mb-8 fade-in" style="animation-delay:0.2s">
                    Baitul Mal Kota Banda Aceh adalah lembaga resmi pengelola zakat, infaq, sedekah, dan harta agama untuk meningkatkan kesejahteraan masyarakat Aceh sesuai syariat Islam.
                </p>
                <div class="flex flex-wrap gap-4 fade-in" style="animation-delay:0.3s">
                    <a href="#bayar-zakat" class="btn-gold px-8 py-3.5 rounded-full font-lato text-base hover:scale-105 transition-transform">
                        Bayar Zakat Sekarang
                    </a>
                    <a href="#program" class="border border-white/30 text-white px-8 py-3.5 rounded-full font-lato text-base hover:bg-white/10 transition-colors">
                        Program Kami
                    </a>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-3 gap-4 mt-12 pt-8 border-t border-white/10 fade-in" style="animation-delay:0.4s">
                    <div>
                        <p class="text-emas-400 font-playfair text-3xl font-bold">23K+</p>
                        <p class="text-white/60 font-lato text-sm mt-1">Muzakki Terdaftar</p>
                    </div>
                    <div>
                        <p class="text-emas-400 font-playfair text-3xl font-bold">8 Asnaf</p>
                        <p class="text-white/60 font-lato text-sm mt-1">Golongan Penerima</p>
                    </div>
                    <div>
                        <p class="text-emas-400 font-playfair text-3xl font-bold">1442H</p>
                        <p class="text-white/60 font-lato text-sm mt-1">Berdiri Sejak</p>
                    </div>
                </div>
            </div>

            {{-- Right - Islamic Geometric Illustration --}}
            <div class="hidden lg:flex justify-center items-center fade-in" style="animation-delay:0.2s">
                <div class="relative w-96 h-96">
                    {{-- Outer ring --}}
                    <div class="absolute inset-0 rounded-full border-2 border-emas-500/30 animate-spin" style="animation-duration:20s"></div>
                    {{-- Octagon shape --}}
                    <div class="absolute inset-8 rounded-full bg-hijau-700/40 backdrop-blur flex items-center justify-center">
                        <div class="text-center">
                            <svg viewBox="0 0 160 160" class="w-40 h-40 mx-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                                {{-- Mosque dome --}}
                                <ellipse cx="80" cy="95" rx="55" ry="50" fill="#167a54" stroke="#c9992c" stroke-width="1.5"/>
                                <path d="M30 95 Q30 55 80 45 Q130 55 130 95" fill="#229668" stroke="#c9992c" stroke-width="1.5"/>
                                {{-- Minaret left --}}
                                <rect x="18" y="70" width="16" height="50" rx="3" fill="#229668" stroke="#c9992c" stroke-width="1"/>
                                <path d="M18 70 Q26 55 34 70" fill="#125f42" stroke="#c9992c" stroke-width="1"/>
                                <circle cx="26" cy="53" r="4" fill="#c9992c"/>
                                {{-- Minaret right --}}
                                <rect x="126" y="70" width="16" height="50" rx="3" fill="#229668" stroke="#c9992c" stroke-width="1"/>
                                <path d="M126 70 Q134 55 142 70" fill="#125f42" stroke="#c9992c" stroke-width="1"/>
                                <circle cx="134" cy="53" r="4" fill="#c9992c"/>
                                {{-- Main door --}}
                                <rect x="66" y="100" width="28" height="45" rx="14" fill="#0e4b34" stroke="#c9992c" stroke-width="1.5"/>
                                {{-- Windows --}}
                                <ellipse cx="56" cy="85" rx="9" ry="12" fill="#0e4b34" stroke="#c9992c" stroke-width="1"/>
                                <ellipse cx="104" cy="85" rx="9" ry="12" fill="#0e4b34" stroke="#c9992c" stroke-width="1"/>
                                {{-- Crescent --}}
                                <path d="M80 30 C74 25 68 32 74 38 C68 38 64 32 70 27 C73 24 77 23 80 25 Z" fill="#c9992c"/>
                                <circle cx="80" cy="20" r="7" fill="none" stroke="#c9992c" stroke-width="1.5"/>
                                {{-- Stars --}}
                                <path d="M44 38 L45.5 42.5 L50 44 L45.5 45.5 L44 50 L42.5 45.5 L38 44 L42.5 42.5 Z" fill="#f5d88a" opacity="0.7"/>
                                <path d="M116 38 L117.5 42.5 L122 44 L117.5 45.5 L116 50 L114.5 45.5 L110 44 L114.5 42.5 Z" fill="#f5d88a" opacity="0.7"/>
                                {{-- Base --}}
                                <rect x="25" y="140" width="110" height="6" rx="3" fill="#c9992c" opacity="0.5"/>
                            </svg>
                            <p class="text-emas-300 font-amiri text-lg mt-2">بَيْتُ الْمَالِ</p>
                            <p class="text-white/60 font-lato text-xs mt-1">Kota Banda Aceh</p>
                        </div>
                    </div>
                    {{-- Orbiting dots --}}
                    <div class="absolute inset-0 animate-spin" style="animation-duration:15s">
                        <div class="absolute top-4 left-1/2 w-3 h-3 bg-emas-400 rounded-full -translate-x-1/2"></div>
                    </div>
                    <div class="absolute inset-0 animate-spin" style="animation-duration:10s;animation-direction:reverse">
                        <div class="absolute bottom-6 right-6 w-2 h-2 bg-emas-300 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave bottom --}}
    <div class="absolute bottom-0 left-0 w-full">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,60 C360,0 1080,0 1440,60 L1440,60 L0,60 Z" fill="#fdfaf4"/>
        </svg>
    </div>
</section>


{{-- ===== TENTANG SECTION ===== --}}
<section id="tentang" class="py-20 bg-krem-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-in">
            <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Tentang Kami</p>
            <h2 class="font-playfair text-3xl md:text-4xl text-hijau-900 mt-2">Amanah dalam Pengelolaan</h2>
            <p class="text-gray-500 font-lato mt-4 max-w-2xl mx-auto text-base leading-relaxed">
                Baitul Mal Kota Banda Aceh dibentuk berdasarkan Qanun Aceh No. 10 Tahun 2007 sebagai lembaga yang bertugas mengelola zakat, wakaf, dan harta agama secara profesional, transparan, dan akuntabel.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Visi --}}
            <div class="bg-white rounded-2xl p-8 text-center border border-hijau-100 fade-in program-card">
                <div class="w-16 h-16 bg-hijau-50 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-xl text-hijau-800 mb-3">Visi</h3>
                <p class="text-gray-500 font-lato text-sm leading-relaxed">
                    Menjadi lembaga pengelola zakat dan harta agama yang amanah, profesional, dan berkontribusi nyata pada kesejahteraan umat di Kota Banda Aceh.
                </p>
            </div>

            {{-- Misi --}}
            <div class="bg-hijau-700 rounded-2xl p-8 text-center fade-in program-card" style="animation-delay:0.1s">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emas-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-xl text-white mb-3">Misi</h3>
                <ul class="text-white/70 font-lato text-sm leading-relaxed space-y-2 text-left">
                    <li class="flex gap-2 items-start"><span class="text-emas-400 mt-0.5">▸</span> Mengoptimalkan pengumpulan zakat dan infaq</li>
                    <li class="flex gap-2 items-start"><span class="text-emas-400 mt-0.5">▸</span> Mendistribusikan secara tepat sasaran</li>
                    <li class="flex gap-2 items-start"><span class="text-emas-400 mt-0.5">▸</span> Meningkatkan kapasitas mustahik</li>
                    <li class="flex gap-2 items-start"><span class="text-emas-400 mt-0.5">▸</span> Mengelola wakaf produktif</li>
                </ul>
            </div>

            {{-- Nilai --}}
            <div class="bg-white rounded-2xl p-8 text-center border border-hijau-100 fade-in program-card" style="animation-delay:0.2s">
                <div class="w-16 h-16 bg-emas-300/20 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-xl text-hijau-800 mb-3">Nilai Kami</h3>
                <div class="grid grid-cols-2 gap-3 text-left">
                    @foreach(['Amanah', 'Transparan', 'Profesional', 'Akuntabel', 'Islami', 'Peduli'] as $nilai)
                    <div class="bg-hijau-50 rounded-lg px-3 py-2">
                        <p class="text-hijau-700 font-lato text-sm font-semibold">{{ $nilai }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== STATISTIK SECTION ===== --}}
<section id="statistik" class="py-20 pattern-bg relative overflow-hidden">
    <div class="absolute inset-0 bg-hijau-900/80"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-14 fade-in">
            <p class="text-emas-400 font-amiri italic text-lg divider-ornament" style="--before-dir:left;--after-dir:right">Statistik 2024</p>
            <h2 class="font-playfair text-3xl md:text-4xl text-white mt-2">Capaian &amp; Kinerja</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $stats = [
                ['value' => 'Rp 47,2 M', 'label' => 'Total Penerimaan Zakat', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['value' => '18.450', 'label' => 'Mustahik Terbantu', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['value' => '342', 'label' => 'Beasiswa Diberikan', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                ['value' => '89 Ha', 'label' => 'Luas Tanah Wakaf', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
            ];
            @endphp

            @foreach($stats as $i => $stat)
            <div class="stat-card bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 text-center hover:bg-white/10 transition-colors fade-in" style="animation-delay:{{ $i * 0.1 }}s">
                <div class="w-12 h-12 bg-emas-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-emas-300 font-playfair text-2xl md:text-3xl font-bold">{{ $stat['value'] }}</p>
                <p class="text-white/60 font-lato text-sm mt-2 leading-snug">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Progress Bar --}}
        <div class="mt-12 bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-8 fade-in">
            <h3 class="text-white font-playfair text-xl mb-6">Realisasi Pengumpulan Zakat 2024</h3>
            <div class="space-y-5">
                @php
                $items = [
                    ['label' => 'Zakat Fitrah', 'pct' => 92, 'color' => 'bg-emas-400'],
                    ['label' => 'Zakat Maal', 'pct' => 78, 'color' => 'bg-hijau-400'],
                    ['label' => 'Infaq & Sedekah', 'pct' => 65, 'color' => 'bg-emas-600'],
                    ['label' => 'Wakaf Tunai', 'pct' => 45, 'color' => 'bg-hijau-300'],
                ];
                @endphp
                @foreach($items as $item)
                <div>
                    <div class="flex justify-between mb-1.5">
                        <span class="text-white/80 font-lato text-sm">{{ $item['label'] }}</span>
                        <span class="text-emas-400 font-lato text-sm font-bold">{{ $item['pct'] }}%</span>
                    </div>
                    <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="{{ $item['color'] }} h-full rounded-full transition-all duration-1000" style="width: {{ $item['pct'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


{{-- ===== PROGRAM SECTION ===== --}}
<section id="program" class="py-20 bg-krem-50 pattern-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-in">
            <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Program Unggulan</p>
            <h2 class="font-playfair text-3xl md:text-4xl text-hijau-900 mt-2">Layanan &amp; Distribusi</h2>
            <p class="text-gray-500 font-lato mt-4 max-w-xl mx-auto text-sm">Kami menyalurkan zakat kepada 8 asnaf melalui program terstruktur demi kemaslahatan umat.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $programs = [
                ['title' => 'Beasiswa Pendidikan', 'desc' => 'Dukungan biaya pendidikan bagi anak-anak fakir miskin dari SD hingga Perguruan Tinggi.', 'color' => 'hijau', 'emoji' => '🎓'],
                ['title' => 'Bantuan Usaha Mikro', 'desc' => 'Modal usaha dan pendampingan bagi mustahik agar mampu mandiri secara ekonomi.', 'color' => 'emas', 'emoji' => '💼'],
                ['title' => 'Santunan Fakir Miskin', 'desc' => 'Penyaluran kebutuhan pokok dan bantuan tunai bagi kaum dhuafa yang membutuhkan.', 'color' => 'hijau', 'emoji' => '🤲'],
                ['title' => 'Rumah Layak Huni', 'desc' => 'Renovasi dan pembangunan rumah bagi keluarga yang tidak memiliki tempat tinggal layak.', 'color' => 'emas', 'emoji' => '🏠'],
                ['title' => 'Kesehatan Gratis', 'desc' => 'Biaya pengobatan dan rawat inap bagi mustahik melalui kerjasama dengan fasilitas kesehatan.', 'color' => 'hijau', 'emoji' => '🏥'],
                ['title' => 'Wakaf Produktif', 'desc' => 'Pengelolaan aset wakaf secara produktif untuk menghasilkan manfaat berkelanjutan.', 'color' => 'emas', 'emoji' => '🌱'],
            ];
            @endphp

            @foreach($programs as $i => $program)
            <div class="program-card bg-white rounded-2xl p-7 border border-hijau-100 fade-in" style="animation-delay:{{ $i * 0.08 }}s">
                <div class="text-4xl mb-4">{{ $program['emoji'] }}</div>
                <h3 class="font-playfair text-lg text-hijau-800 mb-2">{{ $program['title'] }}</h3>
                <p class="text-gray-500 font-lato text-sm leading-relaxed mb-4">{{ $program['desc'] }}</p>
                <a href="#" class="text-hijau-600 font-lato text-sm font-semibold hover:text-hijau-800 inline-flex items-center gap-1 transition-colors">
                    Pelajari Lebih Lanjut
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ===== BAYAR ZAKAT SECTION ===== --}}
<section id="bayar-zakat" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="fade-in">
                <p class="text-emas-500 font-amiri italic text-lg mb-2 divider-ornament">Cara Mudah</p>
                <h2 class="font-playfair text-3xl md:text-4xl text-hijau-900 mb-4">Bayar Zakat &amp; Infaq</h2>
                <p class="text-gray-500 font-lato text-sm leading-relaxed mb-8">
                    Tunaikan kewajiban zakat Anda dengan mudah melalui berbagai saluran pembayaran yang tersedia. Setiap pembayaran akan dikonfirmasi dan disalurkan secara transparan.
                </p>

                <div class="space-y-4">
                    @php
                    $channels = [
                        ['name' => 'Bank Aceh Syariah', 'no' => '12.01.04.000012-7', 'an' => 'Baitul Mal Kota Banda Aceh'],
                        ['name' => 'BSI (Bank Syariah Indonesia)', 'no' => '7193-456-789', 'an' => 'Baitul Mal Banda Aceh'],
                        ['name' => 'Kantor Baitul Mal', 'no' => 'Jl. T. Nyak Arief No. 219, Banda Aceh', 'an' => 'Senin–Jumat, 08.00–16.00 WIB'],
                    ];
                    @endphp

                    @foreach($channels as $ch)
                    <div class="flex gap-4 items-start bg-krem-50 rounded-xl p-4 border border-hijau-100">
                        <div class="w-10 h-10 bg-hijau-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <p class="font-lato font-bold text-hijau-800 text-sm">{{ $ch['name'] }}</p>
                            <p class="text-gray-600 font-lato text-sm font-mono mt-0.5">{{ $ch['no'] }}</p>
                            <p class="text-gray-400 font-lato text-xs mt-0.5">{{ $ch['an'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Kalkulator Zakat --}}
            <div class="fade-in" style="animation-delay:0.2s">
                <div class="bg-hijau-800 rounded-3xl p-8 text-white">
                    <h3 class="font-playfair text-2xl mb-2">Kalkulator Zakat Maal</h3>
                    <p class="text-white/60 font-lato text-sm mb-6">Hitung estimasi zakat maal Anda</p>

                    <div class="space-y-4">
                        <div>
                            <label class="text-white/80 font-lato text-sm mb-1.5 block">Total Harta (Rp)</label>
                            <input type="number" id="harta" placeholder="Contoh: 10000000" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white font-lato text-sm placeholder-white/30 focus:outline-none focus:border-emas-400">
                        </div>
                        <div>
                            <label class="text-white/80 font-lato text-sm mb-1.5 block">Total Hutang (Rp)</label>
                            <input type="number" id="hutang" placeholder="Contoh: 0" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white font-lato text-sm placeholder-white/30 focus:outline-none focus:border-emas-400">
                        </div>

                        <button onclick="hitungZakat()" class="btn-gold w-full py-3.5 rounded-xl font-lato font-bold text-sm hover:scale-[1.02] transition-transform">
                            Hitung Zakat
                        </button>

                        <div id="hasil-zakat" class="hidden bg-white/10 rounded-xl p-5">
                            <p class="text-white/60 font-lato text-xs mb-1">Estimasi Zakat Maal Anda (2,5%)</p>
                            <p id="jumlah-zakat" class="text-emas-400 font-playfair text-3xl font-bold"></p>
                            <p class="text-white/50 font-lato text-xs mt-2">*Nisab: setara 85 gram emas (~Rp 81 juta)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== BERITA SECTION ===== --}}
<section id="berita" class="py-20 bg-krem-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-end mb-12 fade-in">
            <div>
                <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Informasi Terkini</p>
                <h2 class="font-playfair text-3xl md:text-4xl text-hijau-900 mt-2">Berita &amp; Pengumuman</h2>
            </div>
            <a href="#" class="text-hijau-600 font-lato text-sm font-semibold hover:text-hijau-800 inline-flex items-center gap-1 mt-4">
                Lihat Semua Berita <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
            $berita = [
                ['kategori' => 'Pengumuman', 'judul' => 'Pembukaan Pendaftaran Beasiswa Tahun Akademik 2025/2026', 'tgl' => '15 Januari 2025', 'ringkasan' => 'Baitul Mal Kota Banda Aceh membuka pendaftaran beasiswa untuk 350 pelajar dan mahasiswa berprestasi dari keluarga kurang mampu.'],
                ['kategori' => 'Program', 'judul' => 'Penyerahan Bantuan Rumah Layak Huni kepada 42 Keluarga', 'tgl' => '08 Januari 2025', 'ringkasan' => 'Sebanyak 42 keluarga dhuafa di Kota Banda Aceh menerima bantuan renovasi rumah layak huni dari program Baitul Mal.'],
                ['kategori' => 'Kegiatan', 'judul' => 'Sosialisasi Zakat Profesi bagi ASN Kota Banda Aceh', 'tgl' => '02 Januari 2025', 'ringkasan' => 'Baitul Mal menggelar sosialisasi kepada 1.200 ASN tentang kewajiban zakat profesi dan cara mudah pembayarannya.'],
            ];
            @endphp

            @foreach($berita as $i => $artikel)
            <div class="news-card bg-white rounded-2xl overflow-hidden border border-hijau-100 fade-in" style="animation-delay:{{ $i * 0.1 }}s">
                <div class="h-3 {{ $i === 0 ? 'bg-emas-400' : ($i === 1 ? 'bg-hijau-500' : 'bg-hijau-700') }}"></div>
                <div class="p-6">
                    <span class="inline-block bg-hijau-50 text-hijau-600 font-lato text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $artikel['kategori'] }}</span>
                    <h3 class="font-playfair text-base text-hijau-900 mb-3 leading-snug">{{ $artikel['judul'] }}</h3>
                    <p class="text-gray-400 font-lato text-xs mb-3 leading-relaxed">{{ $artikel['ringkasan'] }}</p>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <p class="text-gray-400 font-lato text-xs">{{ $artikel['tgl'] }}</p>
                        <a href="#" class="text-hijau-600 font-lato text-xs font-semibold hover:text-hijau-800">Baca →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ===== KONTAK SECTION ===== --}}
<section id="kontak" class="py-20 pattern-bg relative">
    <div class="absolute inset-0 bg-hijau-900/85"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-14 fade-in">
            <p class="text-emas-400 font-amiri italic text-lg divider-ornament">Hubungi Kami</p>
            <h2 class="font-playfair text-3xl md:text-4xl text-white mt-2">Kantor Baitul Mal</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-10">
            @php
            $contacts = [
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Alamat', 'value' => 'Jl. T. Nyak Arief No. 219, Lamprit, Kec. Banda Raya, Kota Banda Aceh, Aceh 23234'],
                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Telepon', 'value' => '(0651) 755-5510 \nFax: (0651) 755-5511'],
                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Email', 'value' => 'info@baitulmal.bandaacehkota.go.id'],
            ];
            @endphp

            @foreach($contacts as $i => $c)
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 fade-in" style="animation-delay:{{ $i * 0.1 }}s">
                <div class="w-12 h-12 bg-emas-500/20 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $c['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-white font-playfair text-lg mb-2">{{ $c['title'] }}</h3>
                <p class="text-white/60 font-lato text-sm leading-relaxed whitespace-pre-line">{{ $c['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- CTA Banner --}}
        <div class="bg-emas-500/10 border border-emas-500/30 rounded-2xl p-8 text-center fade-in">
            <p class="text-emas-300 font-amiri text-2xl italic mb-3">وَأَقِيمُوا الصَّلَاةَ وَآتُوا الزَّكَاةَ</p>
            <p class="text-white/60 font-lato text-sm mb-6">Dirikanlah shalat dan tunaikanlah zakat — QS. Al-Baqarah: 43</p>
            <a href="#bayar-zakat" class="btn-gold inline-block px-10 py-3.5 rounded-full font-lato font-bold text-sm hover:scale-105 transition-transform">
                Tunaikan Zakat Sekarang
            </a>
        </div>
    </div>
</section>


{{-- ===== FOOTER ===== --}}
<footer class="bg-hijau-900 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-emas-400 flex items-center justify-center">
                        <span class="text-hijau-900 font-bold text-lg font-amiri">ب</span>
                    </div>
                    <div>
                        <p class="text-white font-lato font-bold text-sm">Baitul Mal Kota Banda Aceh</p>
                        <p class="text-white/50 font-lato text-xs">Pengelola Zakat, Infaq & Sedekah</p>
                    </div>
                </div>
                <p class="text-white/50 font-lato text-sm leading-relaxed max-w-xs">
                    Lembaga resmi berdasarkan Qanun Aceh No. 10 Tahun 2007, melayani pengelolaan zakat, wakaf, dan harta agama untuk kesejahteraan umat.
                </p>
            </div>
            <div>
                <h4 class="text-white font-lato font-semibold text-sm mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    @foreach(['Tentang Kami', 'Program', 'Statistik', 'Berita', 'Kontak'] as $link)
                    <li><a href="#" class="text-white/50 hover:text-emas-400 font-lato text-sm transition-colors">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-white font-lato font-semibold text-sm mb-4">Layanan Online</h4>
                <ul class="space-y-2">
                    @foreach(['Bayar Zakat Online', 'Daftar Muzakki', 'Cek Status Mustahik', 'Laporan Keuangan', 'Pengaduan'] as $link)
                    <li><a href="#" class="text-white/50 hover:text-emas-400 font-lato text-sm transition-colors">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-6 flex flex-wrap justify-between items-center gap-4">
            <p class="text-white/40 font-lato text-xs">© {{ date('Y') }} Baitul Mal Kota Banda Aceh. Hak Cipta Dilindungi.</p>
            <p class="text-white/40 font-lato text-xs">Dibuat dengan ❤️ untuk Umat Aceh</p>
        </div>
    </div>
</footer>


<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
    });

    // Mobile menu toggle
    document.getElementById('menu-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Intersection Observer for fade-in
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Zakat Calculator
    function hitungZakat() {
        const harta = parseFloat(document.getElementById('harta').value) || 0;
        const hutang = parseFloat(document.getElementById('hutang').value) || 0;
        const nisab = 81000000;
        const bersih = harta - hutang;
        const hasil = document.getElementById('hasil-zakat');
        const jumlah = document.getElementById('jumlah-zakat');

        hasil.classList.remove('hidden');

        if (bersih >= nisab) {
            const zakat = bersih * 0.025;
            jumlah.textContent = 'Rp ' + zakat.toLocaleString('id-ID');
            jumlah.style.color = '#e8c05e';
        } else {
            jumlah.textContent = 'Belum mencapai nisab';
            jumlah.style.color = '#9ca3af';
        }
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const href = a.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            document.querySelector(href)?.scrollIntoView({ behavior: 'smooth' });
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    });
</script>
</body>
</html>