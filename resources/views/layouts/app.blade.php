<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Baitul Maal') }} - Portal Zakat</title>
    
    <!-- PWA Web Manifest & Theme -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#059669">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased min-h-screen transition-colors duration-200" 
      x-data="{ 
          mobileMenuOpen: false, 
          logoutModalOpen: false,
          toasts: [],
          addToast(message, type = 'success') {
              const id = Date.now();
              this.toasts.push({ id, message, type });
              setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4000);
          }
      }"
      x-init="
          if ('serviceWorker' in navigator) {
              navigator.serviceWorker.register('/sw.js').catch(err => console.log('SW reg error:', err));
          }
          window.addEventListener('toast', e => addToast(e.detail.message, e.detail.type));
      ">

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true" 
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 translate-y-[-10px]"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="pointer-events-auto p-3.5 rounded-xl shadow-md flex items-center gap-3 border transition-all text-xs font-semibold"
                 :class="{
                     'bg-emerald-700 text-white border-emerald-600': toast.type === 'success',
                     'bg-rose-700 text-white border-rose-600': toast.type === 'error',
                     'bg-amber-600 text-white border-amber-500': toast.type === 'warning',
                     'bg-slate-800 text-white border-slate-700': toast.type === 'info'
                 }">
                <p class="flex-1" x-text="toast.message"></p>
                <button @click="toasts = toasts.filter(t => t.id !== toast.id)" class="text-white/80 hover:text-white">
                    ✕
                </button>
            </div>
        </template>
    </div>

    <!-- MAIN APP CONTAINER -->
    <div class="flex h-screen overflow-hidden">

        <!-- DESKTOP SIDEBAR -->
        <aside class="hidden lg:flex flex-col w-60 bg-slate-900 text-slate-100 border-r border-slate-800 flex-shrink-0 z-20">
            <!-- Sidebar Header -->
            <div class="p-4 flex items-center justify-between border-b border-slate-800">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-black text-xs">
                        BM
                    </div>
                    <div>
                        <h2 class="font-extrabold text-sm leading-tight tracking-wide text-white">BAITUL MAAL</h2>
                        <p class="text-[11px] text-emerald-400 font-medium">Portal Zakat</p>
                    </div>
                </a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        type="button" 
                        class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                        :title="darkMode ? 'Mode Terang' : 'Mode Gelap'">
                    <template x-if="darkMode">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('zakat.calculator') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors {{ request()->routeIs('zakat.calculator') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Hitung Zakat
                </a>

                <a href="{{ route('zakat.pay') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors {{ request()->routeIs('zakat.pay') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Bayar Zakat (QRIS)
                </a>

                <a href="{{ route('zakat.history') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors {{ request()->routeIs('zakat.history') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Riwayat Pembayaran
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>

                @if(Auth::user()->isAdminOrPetugas())
                <a href="/admin" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors bg-amber-500 text-slate-950 hover:bg-amber-400 mt-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Filament Panel Admin
                </a>
                @endif
            </nav>

            <!-- User Info Footer -->
            <div class="p-3 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->role === 'admin' ? 'Administrator' : (Auth::user()->role === 'petugas' ? 'Petugas Zakat' : 'Muzakki') }}</p>
                    </div>
                    <button @click="logoutModalOpen = true" title="Keluar" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- MOBILE SIDEBAR DRAWER -->
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 lg:hidden flex">
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false" class="fixed inset-0 bg-slate-950/70"></div>

            <!-- Drawer Container -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-200 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="relative ml-auto w-72 max-w-full bg-slate-900 text-slate-100 flex flex-col h-full z-10 border-l border-slate-800">

                <div class="p-4 flex items-center justify-between border-b border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold text-xs">
                            BM
                        </div>
                        <span class="font-extrabold text-sm text-white">BAITUL MAAL</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-1.5 text-slate-400 hover:text-white">
                            <template x-if="darkMode">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </template>
                            <template x-if="!darkMode">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            </template>
                        </button>
                        <button @click="mobileMenuOpen = false" class="p-1.5 text-slate-400 hover:text-white">
                            ✕
                        </button>
                    </div>
                </div>

                <div class="px-4 py-3 bg-slate-950 border-b border-slate-800">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ Auth::user()->phone ?? 'Muzakki' }}</p>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('zakat.calculator') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg {{ request()->routeIs('zakat.calculator') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        Hitung Zakat
                    </a>
                    <a href="{{ route('zakat.pay') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg {{ request()->routeIs('zakat.pay') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        Bayar Zakat (QRIS)
                    </a>
                    <a href="{{ route('zakat.history') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg {{ request()->routeIs('zakat.history') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        Riwayat Pembayaran
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                        Profil Saya
                    </a>
                    @if(Auth::user()->isAdminOrPetugas())
                    <a href="/admin" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg bg-amber-500 text-slate-950 mt-4">
                        Filament Panel Admin
                    </a>
                    @endif
                </nav>

                <div class="p-3 border-t border-slate-800">
                    <button @click="logoutModalOpen = true" class="w-full py-2 px-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-lg transition-colors">
                        Keluar dari Akun
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors">

            <!-- MOBILE TOP HEADER -->
            <header class="lg:hidden bg-slate-900 text-white px-4 py-3 flex items-center justify-between shadow-sm z-10 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-black text-xs">
                        BM
                    </div>
                    <span class="font-extrabold text-sm text-white">BAITUL MAAL</span>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-1.5 text-slate-400 hover:text-white">
                        <template x-if="darkMode">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </template>
                        <template x-if="!darkMode">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </template>
                    </button>

                    <!-- 3-DOTS MENU BUTTON -->
                    <button @click="mobileMenuOpen = true" type="button" class="p-1.5 text-slate-200 hover:text-white" title="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- MAIN SCROLLABLE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-5 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 flex items-center justify-between shadow-xs">
                        <p class="text-xs font-semibold">{{ session('success') }}</p>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">✕</button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-5 p-3.5 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 flex items-center justify-between shadow-xs">
                        <p class="text-xs font-semibold">{{ session('error') }}</p>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700">✕</button>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div x-show="logoutModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="logoutModalOpen" x-transition:enter="transition-opacity ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="logoutModalOpen = false" class="fixed inset-0 bg-slate-950/70"></div>

        <div x-show="logoutModalOpen" x-transition:enter="transition ease-out duration-150 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white dark:bg-slate-900 border dark:border-slate-800 rounded-2xl p-6 max-w-sm w-full shadow-xl z-10 text-center space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Konfirmasi Keluar</h3>
            <p class="text-xs text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin keluar dari akun Baitul Maal?</p>

            <div class="flex items-center justify-center gap-3 pt-2">
                <button type="button" @click="logoutModalOpen = false" class="w-1/2 py-2 px-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-lg transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="w-1/2">
                    @csrf
                    <button type="submit" class="w-full py-2 px-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
