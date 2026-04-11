<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Baitul Mal Kota Banda Aceh - Lembaga resmi pengelola zakat, infaq, dan sedekah untuk kesejahteraan umat">
    <title>Baitul Mal Kota Banda Aceh</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        hijau: { 50:'#f0faf5',100:'#d6f1e4',200:'#aee3ca',300:'#77cda8',400:'#43b282',500:'#229668',600:'#167a54',700:'#125f42',800:'#0e4b34',900:'#0a3426' },
                        emas:  { 300:'#f5d88a',400:'#e8c05e',500:'#c9992c',600:'#a07420' },
                        krem:  { 50:'#fdfaf4',100:'#f7f0df' },
                    },
                    fontFamily: {
                        amiri:    ['Amiri','serif'],
                        lato:     ['Lato','sans-serif'],
                        playfair: ['Playfair Display','serif'],
                    },
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family:'Lato',sans-serif; background-color:#fdfaf4; color:#1a2e22; }

        .pattern-bg {
            background-color:#0e4b34;
        }

        .hero-bg {
            background: linear-gradient(to bottom, rgba(14, 75, 52, 0.9) 0%, rgba(14, 75, 52, 0.7) 50%, rgba(14, 75, 52, 0.3) 100%), url('/img/masjid1.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .pattern-light {
            background-image:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23229668' fill-opacity='0.05'%3E%3Cpath d='M20 0L40 20L20 40L0 20Z'/%3E%3C/g%3E%3C/svg%3E");
        }

        @keyframes shimmer {
            0%  { background-position:-200% center; }
            100%{ background-position: 200% center; }
        }
        .btn-gold {
            background:linear-gradient(90deg,#c9992c,#f5d88a,#c9992c,#e8c05e);
            background-size:300% auto;
            animation:shimmer 4s linear infinite;
            color:#0e4b34;
            font-weight:700;
            letter-spacing:.04em;
        }

        #navbar { transition:all .3s ease; }
        #navbar.scrolled { box-shadow:0 4px 24px rgba(14,75,52,.2); background-color:rgba(14,75,52,.98)!important; }

        /* Hamburger slide */
        #mobile-menu { max-height:0; overflow:hidden; transition:max-height .35s ease; }
        #mobile-menu.open { max-height:420px; }

        /* Bar → X */
        #bar1,#bar2,#bar3 { transition:all .3s ease; transform-origin:center; }
        .menu-open #bar1 { transform:translateY(6px) rotate(45deg); }
        .menu-open #bar2 { opacity:0; transform:scaleX(0); }
        .menu-open #bar3 { transform:translateY(-6px) rotate(-45deg); }

        /* Card hover (pointer devices only) */
        .program-card { transition:transform .28s ease, box-shadow .28s ease; }
        @media(hover:hover){ .program-card:hover{ transform:translateY(-5px); box-shadow:0 16px 36px rgba(14,75,52,.16); } }
        .news-card { transition:box-shadow .2s ease; }
        @media(hover:hover){ .news-card:hover{ box-shadow:0 8px 32px rgba(14,75,52,.12); } }

        /* Ornament */
        .divider-ornament::before,.divider-ornament::after {
            content:''; display:inline-block; width:36px; height:1px;
            background:linear-gradient(90deg,transparent,#c9992c);
            vertical-align:middle; margin:0 9px;
        }
        .divider-ornament::after { background:linear-gradient(90deg,#c9992c,transparent); }

        /* Fade on scroll */
        .fade-in { opacity:0; transform:translateY(20px); transition:opacity .65s ease, transform .65s ease; }
        .fade-in.visible { opacity:1; transform:translateY(0); }

        /* ── Floating Action Button (mobile only) ── */
        #fab { display:none; }
        @media(max-width:767px){
            #fab { display:flex; }
            body { padding-bottom:76px; }
        }
        #fab { transition:opacity .3s ease; }

        /* Safe area bottom */
        @supports(padding-bottom:env(safe-area-inset-bottom)){
            #fab { padding-bottom:calc(12px + env(safe-area-inset-bottom)); }
        }

        /* Touch tap targets */
        @media(max-width:767px){ a,button{ min-height:44px; } }

        /* Input */
        input:focus { outline:none; border-color:#e8c05e!important; box-shadow:0 0 0 3px rgba(232,192,94,.2); }

        /* Mobile stats: horizontal scroll */
        @media(max-width:499px){
            .hero-stats { display:flex; overflow-x:auto; gap:16px; padding-bottom:4px; -webkit-overflow-scrolling:touch; scrollbar-width:none; }
            .hero-stats::-webkit-scrollbar { display:none; }
            .hero-stats > * { flex:0 0 130px; }
        }
    </style>
</head>
<body class="antialiased">

{{-- ===== FLOATING ACTION BUTTON (mobile) ===== --}}
<div id="fab" class="fixed bottom-0 left-0 right-0 z-40 px-4 py-3 pointer-events-none"
     style="background:linear-gradient(to top,rgba(10,52,38,.9) 0%,transparent 100%)">
    <a href="#bayar-zakat"
       class="btn-gold w-full py-3.5 rounded-2xl text-base text-center font-lato shadow-2xl pointer-events-auto flex items-center justify-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Bayar Zakat Sekarang
    </a>
</div>

{{-- ===== NAVBAR ===== --}}
<nav id="navbar" class="fixed top-0 w-full z-50 pattern-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5 flex-shrink-0 min-h-0">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="/img/logo-baitulmal.png" alt="Logo Baitul Mal" class="w-50">
                </div>
                <div>
                    <p class="text-white font-lato font-bold text-xs sm:text-sm leading-tight">Baitul Mal</p>
                    <p class="text-emas-300 font-lato text-xs leading-tight">Kota Banda Aceh</p>
                </div>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-5 lg:gap-6">
                <a href="#tentang"   class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Tentang</a>
                <a href="#program"   class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Program</a>
                <a href="#statistik" class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Statistik</a>
                <a href="#berita"    class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Berita</a>
                <a href="#kontak"    class="text-white/80 hover:text-emas-300 text-sm font-lato transition-colors">Kontak</a>
                <a href="#bayar-zakat" class="btn-gold px-5 py-2.5 rounded-full text-sm hover:scale-105 transition-transform">Bayar Zakat</a>
            </div>

            {{-- Hamburger --}}
            <button id="menu-btn" class="md:hidden text-white p-2 -mr-1 rounded-lg focus:outline-none focus:ring-2 focus:ring-emas-400/40"
                    aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                    <line id="bar1" x1="3" y1="6"  x2="21" y2="6"/>
                    <line id="bar2" x1="3" y1="12" x2="21" y2="12"/>
                    <line id="bar3" x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="md:hidden bg-hijau-900 border-t border-white/10">
        <div class="px-4 py-2 space-y-0.5">
            <a href="#tentang"   class="block py-3 px-2 text-white/80 hover:text-emas-300 text-sm border-b border-white/5">Tentang</a>
            <a href="#program"   class="block py-3 px-2 text-white/80 hover:text-emas-300 text-sm border-b border-white/5">Program</a>
            <a href="#statistik" class="block py-3 px-2 text-white/80 hover:text-emas-300 text-sm border-b border-white/5">Statistik</a>
            <a href="#berita"    class="block py-3 px-2 text-white/80 hover:text-emas-300 text-sm border-b border-white/5">Berita</a>
            <a href="#kontak"    class="block py-3 px-2 text-white/80 hover:text-emas-300 text-sm border-b border-white/5">Kontak</a>
            <div class="pt-3 pb-2">
                <a href="#bayar-zakat" class="btn-gold block text-center px-5 py-3 rounded-xl text-sm">Bayar Zakat</a>
            </div>
        </div>
    </div>
</nav>


{{-- ===== HERO ===== --}}
<section class="hero-bg min-h-screen flex items-center relative overflow-hidden">
    <div class="absolute -top-20 -right-20 w-64 sm:w-96 h-64 sm:h-96 rounded-full border border-emas-500/10 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 rounded-full bg-hijau-700/30 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">

            {{-- Text --}}
            <div class="text-center lg:text-left">
                <p class="text-emas-400 font-amiri text-lg sm:text-xl italic mb-3 fade-in">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>

                <h1 class="text-white font-playfair text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] leading-tight mb-4 fade-in" style="animation-delay:.1s">
                    Zakat &amp; Sedekah<br>
                    <span class="text-emas-400">untuk Umat</span>
                </h1>

                <p class="text-white/70 font-lato text-base sm:text-lg leading-relaxed mb-7 fade-in max-w-xl mx-auto lg:mx-0" style="animation-delay:.2s">
                    Baitul Mal Kota Banda Aceh adalah lembaga resmi pengelola zakat, infaq, sedekah, dan harta agama untuk meningkatkan kesejahteraan masyarakat Aceh sesuai syariat Islam.
                </p>

                {{-- CTA --}}
                <div class="flex flex-col sm:flex-row gap-3 fade-in justify-center lg:justify-start" style="animation-delay:.3s">
                    <a href="#bayar-zakat" class="btn-gold px-7 py-3.5 rounded-full font-lato text-base text-center hover:scale-105 transition-transform">
                        Bayar Zakat Sekarang
                    </a>
                    <a href="#program" class="border border-white/30 text-white px-7 py-3.5 rounded-full font-lato text-base text-center hover:bg-white/10 transition-colors">
                        Program Kami
                    </a>
                </div>

                {{-- Mini Stats --}}
                <div class="mt-10 pt-7 border-t border-white/10 fade-in" style="animation-delay:.4s">
                    <div class="hero-stats grid grid-cols-3 gap-4 sm:gap-6">
                        @php $heroStats=[['val'=>'23K+','lbl'=>'Muzakki'],['val'=>'8 Asnaf','lbl'=>'Golongan Penerima'],['val'=>'1442H','lbl'=>'Berdiri Sejak']]; @endphp
                        @foreach($heroStats as $hs)
                        <div class="text-center lg:text-left">
                            <p class="text-emas-400 font-playfair text-xl sm:text-2xl md:text-3xl font-bold">{{ $hs['val'] }}</p>
                            <p class="text-white/60 font-lato text-xs sm:text-sm mt-0.5">{{ $hs['lbl'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Masjid Illustration (desktop only) --}}
            <div class="hidden lg:flex justify-center items-center fade-in" style="animation-delay:.2s">
                <img src="/img/logo-baitulmal.png" alt="Logo Baitul Mal" class="w-[400px] translate-x-40"> 
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full pointer-events-none">
        <svg viewBox="0 0 1440 50" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,50 C360,0 1080,0 1440,50 L1440,50 L0,50 Z" fill="#fdfaf4"/>
        </svg>
    </div>
</section>


{{-- ===== TENTANG ===== --}}
<section id="tentang" class="py-14 sm:py-20 bg-krem-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14 fade-in">
            <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Tentang Kami</p>
            <h2 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-hijau-900 mt-2">Amanah dalam Pengelolaan</h2>
            <p class="text-gray-500 font-lato mt-3 max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
                Baitul Mal Kota Banda Aceh dibentuk berdasarkan Qanun Aceh No. 10 Tahun 2007 sebagai lembaga pengelola zakat, wakaf, dan harta agama secara profesional, transparan, dan akuntabel.
            </p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-8">
            {{-- Visi --}}
            <div class="bg-white rounded-2xl p-6 sm:p-8 text-center border border-hijau-100 fade-in program-card">
                <div class="w-14 h-14 bg-hijau-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-lg sm:text-xl text-hijau-800 mb-3">Visi</h3>
                <p class="text-gray-500 font-lato text-sm leading-relaxed">Menjadi lembaga pengelola zakat dan harta agama yang amanah, profesional, dan berkontribusi nyata pada kesejahteraan umat di Kota Banda Aceh.</p>
            </div>
            {{-- Misi --}}
            <div class="bg-hijau-700 rounded-2xl p-6 sm:p-8 text-center fade-in program-card" style="animation-delay:.1s">
                <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emas-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-lg sm:text-xl text-white mb-3">Misi</h3>
                <ul class="text-white/70 font-lato text-sm leading-relaxed space-y-2 text-left">
                    <li class="flex gap-2"><span class="text-emas-400 flex-shrink-0 mt-0.5">▸</span>Mengoptimalkan pengumpulan zakat dan infaq</li>
                    <li class="flex gap-2"><span class="text-emas-400 flex-shrink-0 mt-0.5">▸</span>Mendistribusikan secara tepat sasaran</li>
                    <li class="flex gap-2"><span class="text-emas-400 flex-shrink-0 mt-0.5">▸</span>Meningkatkan kapasitas mustahik</li>
                    <li class="flex gap-2"><span class="text-emas-400 flex-shrink-0 mt-0.5">▸</span>Mengelola wakaf produktif</li>
                </ul>
            </div>
            {{-- Nilai --}}
            <div class="bg-white rounded-2xl p-6 sm:p-8 text-center border border-hijau-100 fade-in program-card sm:col-span-2 lg:col-span-1" style="animation-delay:.2s">
                <div class="w-14 h-14 bg-emas-300/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-playfair text-lg sm:text-xl text-hijau-800 mb-3">Nilai Kami</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 gap-2">
                    @foreach(['Amanah','Transparan','Profesional','Akuntabel','Islami','Peduli'] as $n)
                    <div class="bg-hijau-50 rounded-lg px-3 py-2 text-left">
                        <p class="text-hijau-700 font-lato text-sm font-semibold">{{ $n }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== STATISTIK ===== --}}
<section id="statistik" class="py-14 sm:py-20 pattern-bg relative overflow-hidden">
    <div class="absolute inset-0 bg-hijau-900/80"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-10 sm:mb-14 fade-in">
            <p class="text-emas-400 font-amiri italic text-lg divider-ornament">Statistik 2024</p>
            <h2 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-white mt-2">Capaian &amp; Kinerja</h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 lg:gap-6">
            @php
            $stats=[
                ['value'=>'Rp 47,2 M','label'=>'Total Penerimaan Zakat','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['value'=>'18.450','label'=>'Mustahik Terbantu','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['value'=>'342','label'=>'Beasiswa Diberikan','icon'=>'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                ['value'=>'89 Ha','label'=>'Luas Tanah Wakaf','icon'=>'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
            ];
            @endphp
            @foreach($stats as $i=>$s)
            <div class="bg-white/5 border border-white/10 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center hover:bg-white/10 transition-colors fade-in" style="animation-delay:{{ $i*.1 }}s">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emas-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $s['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-emas-300 font-playfair text-xl sm:text-2xl md:text-3xl font-bold">{{ $s['value'] }}</p>
                <p class="text-white/60 font-lato text-xs sm:text-sm mt-1 leading-snug">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-8 sm:mt-12 bg-white/5 border border-white/10 rounded-xl sm:rounded-2xl p-5 sm:p-8 fade-in">
            <h3 class="text-white font-playfair text-lg sm:text-xl mb-5">Realisasi Pengumpulan Zakat 2024</h3>
            <div class="space-y-4">
                @php $bars=[['label'=>'Zakat Fitrah','pct'=>92,'color'=>'bg-emas-400'],['label'=>'Zakat Maal','pct'=>78,'color'=>'bg-hijau-400'],['label'=>'Infaq & Sedekah','pct'=>65,'color'=>'bg-emas-600'],['label'=>'Wakaf Tunai','pct'=>45,'color'=>'bg-hijau-300']]; @endphp
                @foreach($bars as $b)
                <div>
                    <div class="flex justify-between mb-1.5">
                        <span class="text-white/80 font-lato text-xs sm:text-sm">{{ $b['label'] }}</span>
                        <span class="text-emas-400 font-lato text-xs sm:text-sm font-bold">{{ $b['pct'] }}%</span>
                    </div>
                    <div class="h-2 sm:h-2.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="{{ $b['color'] }} h-full rounded-full" style="width:{{ $b['pct'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


{{-- ===== PROGRAM ===== --}}
<section id="program" class="py-14 sm:py-20 bg-krem-50 pattern-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14 fade-in">
            <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Program Unggulan</p>
            <h2 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-hijau-900 mt-2">Layanan &amp; Distribusi</h2>
            <p class="text-gray-500 font-lato mt-3 max-w-xl mx-auto text-sm sm:text-base">Kami menyalurkan zakat kepada 8 asnaf melalui program terstruktur demi kemaslahatan umat.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            @php
            $programs=[
                ['title'=>'Beasiswa Pendidikan','desc'=>'Dukungan biaya pendidikan bagi anak-anak fakir miskin dari SD hingga Perguruan Tinggi.','emoji'=>'🎓'],
                ['title'=>'Bantuan Usaha Mikro','desc'=>'Modal usaha dan pendampingan bagi mustahik agar mampu mandiri secara ekonomi.','emoji'=>'💼'],
                ['title'=>'Santunan Fakir Miskin','desc'=>'Penyaluran kebutuhan pokok dan bantuan tunai bagi kaum dhuafa yang membutuhkan.','emoji'=>'🤲'],
                ['title'=>'Rumah Layak Huni','desc'=>'Renovasi dan pembangunan rumah bagi keluarga yang tidak memiliki tempat tinggal layak.','emoji'=>'🏠'],
                ['title'=>'Kesehatan Gratis','desc'=>'Biaya pengobatan dan rawat inap bagi mustahik melalui kerjasama fasilitas kesehatan.','emoji'=>'🏥'],
                ['title'=>'Wakaf Produktif','desc'=>'Pengelolaan aset wakaf secara produktif untuk menghasilkan manfaat berkelanjutan.','emoji'=>'🌱'],
            ];
            @endphp
            @foreach($programs as $i=>$p)
            <div class="program-card bg-white rounded-xl sm:rounded-2xl p-5 sm:p-7 border border-hijau-100 fade-in" style="animation-delay:{{ $i*.07 }}s">
                <div class="text-3xl sm:text-4xl mb-3">{{ $p['emoji'] }}</div>
                <h3 class="font-playfair text-base sm:text-lg text-hijau-800 mb-2">{{ $p['title'] }}</h3>
                <p class="text-gray-500 font-lato text-sm leading-relaxed mb-3">{{ $p['desc'] }}</p>
                <a href="#" class="text-hijau-600 font-lato text-sm font-semibold hover:text-hijau-800 inline-flex items-center gap-1 transition-colors">
                    Pelajari Lebih Lanjut <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ===== BAYAR ZAKAT ===== --}}
<section id="bayar-zakat" class="py-14 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 fade-in lg:hidden">
            <p class="text-emas-500 font-amiri italic text-lg divider-ornament">Cara Mudah</p>
            <h2 class="font-playfair text-2xl sm:text-3xl text-hijau-900 mt-2">Bayar Zakat &amp; Infaq</h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
            {{-- Rekening --}}
            <div class="fade-in">
                <div class="hidden lg:block mb-6">
                    <p class="text-emas-500 font-amiri italic text-lg mb-1 divider-ornament">Cara Mudah</p>
                    <h2 class="font-playfair text-3xl md:text-4xl text-hijau-900 mt-2">Bayar Zakat &amp; Infaq</h2>
                    <p class="text-gray-500 font-lato text-sm leading-relaxed mt-3">Tunaikan kewajiban zakat Anda melalui berbagai saluran pembayaran yang tersedia.</p>
                </div>
                <div class="space-y-3">
                    @php
                    $channels=[
                        ['name'=>'Bank Aceh Syariah','no'=>'12.01.04.000012-7','an'=>'Baitul Mal Kota Banda Aceh'],
                        ['name'=>'BSI (Bank Syariah Indonesia)','no'=>'7193-456-789','an'=>'Baitul Mal Banda Aceh'],
                        ['name'=>'Kantor Baitul Mal','no'=>'Jl. T. Nyak Arief No. 219, Banda Aceh','an'=>'Senin–Jumat, 08.00–16.00 WIB'],
                    ];
                    @endphp
                    @foreach($channels as $ch)
                    <div class="flex gap-3 items-start bg-krem-50 rounded-xl p-3.5 sm:p-4 border border-hijau-100">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-hijau-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-hijau-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-lato font-bold text-hijau-800 text-sm">{{ $ch['name'] }}</p>
                            <p class="text-gray-600 font-lato text-sm font-mono mt-0.5 break-all">{{ $ch['no'] }}</p>
                            <p class="text-gray-400 font-lato text-xs mt-0.5">{{ $ch['an'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Kalkulator --}}
            <div class="fade-in" style="animation-delay:.2s">
                <div class="bg-hijau-800 rounded-2xl sm:rounded-3xl p-5 sm:p-8 text-white">
                    <h3 class="font-playfair text-xl sm:text-2xl mb-1.5">Kalkulator Zakat Maal</h3>
                    <p class="text-white/60 font-lato text-sm mb-5">Hitung estimasi zakat maal Anda</p>
                    <div class="space-y-4">
                        <div>
                            <label class="text-white/80 font-lato text-sm mb-1.5 block">Total Harta (Rp)</label>
                            <input type="number" inputmode="numeric" id="harta" placeholder="Contoh: 10000000"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white font-lato text-sm placeholder-white/30 transition-all">
                        </div>
                        <div>
                            <label class="text-white/80 font-lato text-sm mb-1.5 block">Total Hutang (Rp)</label>
                            <input type="number" inputmode="numeric" id="hutang" placeholder="Contoh: 0"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white font-lato text-sm placeholder-white/30 transition-all">
                        </div>
                        <button onclick="hitungZakat()" class="btn-gold w-full py-3.5 rounded-xl font-lato font-bold text-sm active:scale-95 transition-transform">
                            Hitung Zakat Saya
                        </button>
                        <div id="hasil-zakat" class="hidden bg-white/10 rounded-xl p-4 sm:p-5">
                            <p class="text-white/60 font-lato text-xs mb-1">Estimasi Zakat Maal Anda (2,5%)</p>
                            <p id="jumlah-zakat" class="text-emas-400 font-playfair text-2xl sm:text-3xl font-bold"></p>
                            <p class="text-white/50 font-lato text-xs mt-2">*Nisab: setara 85 gram emas (~Rp 81 juta)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== BERITA ===== --}}
<section id="berita" class="py-14 sm:py-20 bg-krem-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-end gap-3 mb-8 sm:mb-12 fade-in">
            <div>
                <p class="text-hijau-600 font-amiri italic text-lg divider-ornament">Informasi Terkini</p>
                <h2 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-hijau-900 mt-2">Berita &amp; Pengumuman</h2>
            </div>
            <a href="#" class="text-hijau-600 font-lato text-sm font-semibold hover:text-hijau-800 inline-flex items-center gap-1">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            @php
            $berita=[
                ['kategori'=>'Pengumuman','judul'=>'Pembukaan Pendaftaran Beasiswa Tahun Akademik 2025/2026','tgl'=>'15 Jan 2025','ringkasan'=>'Baitul Mal membuka pendaftaran beasiswa untuk 350 pelajar dari keluarga kurang mampu.','accent'=>'bg-emas-400'],
                ['kategori'=>'Program','judul'=>'Penyerahan Bantuan Rumah Layak Huni kepada 42 Keluarga','tgl'=>'08 Jan 2025','ringkasan'=>'Sebanyak 42 keluarga dhuafa menerima bantuan renovasi rumah layak huni dari program Baitul Mal.','accent'=>'bg-hijau-500'],
                ['kategori'=>'Kegiatan','judul'=>'Sosialisasi Zakat Profesi bagi ASN Kota Banda Aceh','tgl'=>'02 Jan 2025','ringkasan'=>'Baitul Mal menggelar sosialisasi kepada 1.200 ASN tentang kewajiban zakat profesi.','accent'=>'bg-hijau-700'],
            ];
            @endphp
            @foreach($berita as $i=>$a)
            <div class="news-card bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-hijau-100 fade-in" style="animation-delay:{{ $i*.1 }}s">
                <div class="h-2.5 {{ $a['accent'] }}"></div>
                <div class="p-4 sm:p-6">
                    <span class="inline-block bg-hijau-50 text-hijau-600 font-lato text-xs font-semibold px-3 py-1 rounded-full mb-3">{{ $a['kategori'] }}</span>
                    <h3 class="font-playfair text-sm sm:text-base text-hijau-900 mb-2 leading-snug">{{ $a['judul'] }}</h3>
                    <p class="text-gray-400 font-lato text-xs leading-relaxed mb-3">{{ $a['ringkasan'] }}</p>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <p class="text-gray-400 font-lato text-xs">{{ $a['tgl'] }}</p>
                        <a href="#" class="text-hijau-600 font-lato text-xs font-semibold hover:text-hijau-800">Baca →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ===== KONTAK ===== --}}
<section id="kontak" class="py-14 sm:py-20 pattern-bg relative">
    <div class="absolute inset-0 bg-hijau-900/85"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-10 sm:mb-14 fade-in">
            <p class="text-emas-400 font-amiri italic text-lg divider-ornament">Hubungi Kami</p>
            <h2 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-white mt-2">Kantor Baitul Mal</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 mb-8">
            @php
            $contacts=[
                ['icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','title'=>'Alamat','value'=>"Jl. T. Nyak Arief No. 219\nLamprit, Banda Raya\nBanda Aceh 23234"],
                ['icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z','title'=>'Telepon','value'=>"(0651) 755-5510\nFax: (0651) 755-5511"],
                ['icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','title'=>'Email','value'=>'info@baitulmal.bandaacehkota.go.id'],
            ];
            @endphp
            @foreach($contacts as $i=>$c)
            <div class="bg-white/5 border border-white/10 rounded-xl sm:rounded-2xl p-5 fade-in" style="animation-delay:{{ $i*.1 }}s">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-emas-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emas-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $c['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-playfair text-base sm:text-lg mb-1.5">{{ $c['title'] }}</h3>
                        <p class="text-white/60 font-lato text-sm leading-relaxed whitespace-pre-line break-all">{{ $c['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="bg-emas-500/10 border border-emas-500/30 rounded-xl sm:rounded-2xl p-6 sm:p-8 text-center fade-in">
            <p class="text-emas-300 font-amiri text-xl sm:text-2xl italic mb-2">وَأَقِيمُوا الصَّلَاةَ وَآتُوا الزَّكَاةَ</p>
            <p class="text-white/60 font-lato text-xs sm:text-sm mb-5">Dirikanlah shalat dan tunaikanlah zakat — QS. Al-Baqarah: 43</p>
            <a href="#bayar-zakat" class="btn-gold inline-block px-8 sm:px-10 py-3.5 rounded-full font-lato font-bold text-sm hover:scale-105 transition-transform">
                Tunaikan Zakat Sekarang
            </a>
        </div>
    </div>
</section>


{{-- ===== FOOTER ===== --}}
<footer class="bg-hijau-900 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mb-8">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-emas-400 flex items-center justify-center flex-shrink-0">
                        <span class="text-hijau-900 font-bold text-lg font-amiri">ب</span>
                    </div>
                    <div>
                        <p class="text-white font-lato font-bold text-sm">Baitul Mal Kota Banda Aceh</p>
                        <p class="text-white/50 font-lato text-xs">Pengelola Zakat, Infaq & Sedekah</p>
                    </div>
                </div>
                <p class="text-white/50 font-lato text-sm leading-relaxed max-w-xs">
                    Lembaga resmi berdasarkan Qanun Aceh No. 10 Tahun 2007 untuk kesejahteraan umat.
                </p>
            </div>
            <div>
                <h4 class="text-white font-lato font-semibold text-sm mb-3">Tautan Cepat</h4>
                <ul class="space-y-1.5">
                    @foreach(['Tentang Kami','Program','Statistik','Berita','Kontak'] as $link)
                    <li><a href="#" class="text-white/50 hover:text-emas-400 font-lato text-sm transition-colors block py-0.5">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-white font-lato font-semibold text-sm mb-3">Layanan</h4>
                <ul class="space-y-1.5">
                    @foreach(['Bayar Zakat','Daftar Muzakki','Status Mustahik','Laporan Keuangan','Pengaduan'] as $link)
                    <li><a href="#" class="text-white/50 hover:text-emas-400 font-lato text-sm transition-colors block py-0.5">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-5 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="text-white/40 font-lato text-xs text-center sm:text-left">© {{ date('Y') }} Baitul Mal Kota Banda Aceh. Hak Cipta Dilindungi.</p>
            <p class="text-white/40 font-lato text-xs">Dibuat dengan ❤️ untuk Umat Aceh</p>
        </div>
    </div>
</footer>


<script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    }, { passive: true });

    // Hamburger toggle
    const menuBtn    = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    let open = false;

    menuBtn.addEventListener('click', () => {
        open = !open;
        menuBtn.classList.toggle('menu-open', open);
        mobileMenu.classList.toggle('open', open);
        menuBtn.setAttribute('aria-expanded', String(open));
    });

    // Close menu + smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const href = a.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            document.querySelector(href)?.scrollIntoView({ behavior: 'smooth' });
            open = false;
            menuBtn.classList.remove('menu-open');
            mobileMenu.classList.remove('open');
            menuBtn.setAttribute('aria-expanded', 'false');
        });
    });

    // Intersection Observer — fade-in
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.08 });
    document.querySelectorAll('.fade-in').forEach(el => io.observe(el));

    // FAB: hide when kontak section is visible
    const fab = document.getElementById('fab');
    const kontakEl = document.getElementById('kontak');
    fab.style.transition = 'opacity .3s ease';
    if (kontakEl) {
        new IntersectionObserver(([entry]) => {
            fab.style.opacity  = entry.isIntersecting ? '0' : '1';
            fab.style.pointerEvents = entry.isIntersecting ? 'none' : 'auto';
        }, { threshold: 0.15 }).observe(kontakEl);
    }

    // Zakat Calculator
    function hitungZakat() {
        const harta  = parseFloat(document.getElementById('harta').value)  || 0;
        const hutang = parseFloat(document.getElementById('hutang').value) || 0;
        const nisab  = 81_000_000;
        const bersih = harta - hutang;
        const hasil  = document.getElementById('hasil-zakat');
        const jumlah = document.getElementById('jumlah-zakat');

        hasil.classList.remove('hidden');

        if (bersih >= nisab) {
            const zakat = Math.round(bersih * 0.025);
            jumlah.textContent = 'Rp ' + zakat.toLocaleString('id-ID');
            jumlah.style.color = '#e8c05e';
        } else {
            jumlah.textContent = 'Belum mencapai nisab';
            jumlah.style.color = '#9ca3af';
        }

        hasil.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Enter key on inputs
    ['harta', 'hutang'].forEach(id => {
        document.getElementById(id)?.addEventListener('keydown', e => {
            if (e.key === 'Enter') hitungZakat();
        });
    });
</script>
</body>
</html>