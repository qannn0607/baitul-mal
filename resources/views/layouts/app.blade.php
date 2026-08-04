<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Baitul Maal') }} - Portal Zakat</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen" x-data="{ mobileMenuOpen: false, logoutModalOpen: false }">

    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">

        <!-- DESKTOP SIDEBAR (Visible on lg+) -->
        <aside class="hidden lg:flex flex-col w-64 bg-emerald-900 text-white shadow-2xl flex-shrink-0 z-20">
            <!-- Sidebar Header -->
            <div class="p-6 flex items-center gap-3 border-b border-emerald-800/60">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-700/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4m0 4h4m-4-4l-4 4m8-4l4 4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-lg leading-tight tracking-wide text-white">BAITUL MAAL</h2>
                    <p class="text-xs text-emerald-300 font-medium">Sistem Zakat Digital</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-800/40' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('zakat.calculator') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('zakat.calculator') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-800/40' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Hitung Zakat
                </a>

                <a href="{{ route('zakat.pay') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('zakat.pay') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-800/40' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Bayar Zakat (QRIS)
                </a>

                <a href="{{ route('zakat.history') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('zakat.history') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-800/40' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Riwayat Pembayaran
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-800/40' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>

                @if(Auth::user()->isAdmin())
                <a href="/admin" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 bg-amber-500 text-amber-950 hover:bg-amber-400 mt-4 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Filament Admin Panel
                </a>
                @endif
            </nav>

            <!-- User Info & Logout Footer -->
            <div class="p-4 border-t border-emerald-800/60 bg-emerald-950/40">
                <div class="flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-emerald-300 truncate">{{ Auth::user()->phone ?? 'Muzakki' }}</p>
                    </div>
                    <button @click="logoutModalOpen = true" title="Keluar" class="p-2 text-emerald-200 hover:text-red-400 hover:bg-emerald-800/50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- MOBILE SIDEBAR DRAWER (Off-canvas) -->
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 lg:hidden flex">
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

            <!-- Drawer Container -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="relative ml-auto w-80 max-w-full bg-emerald-900 text-white flex flex-col shadow-2xl h-full z-10">

                <div class="p-5 flex items-center justify-between border-b border-emerald-800">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-500 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4m0 4h4m-4-4l-4 4m8-4l4 4"/></svg>
                        </div>
                        <span class="font-bold text-lg text-white">BAITUL MAAL</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-2 text-emerald-200 hover:text-white rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="px-4 py-4 bg-emerald-950/50 border-b border-emerald-800">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-emerald-300 truncate mt-0.5">{{ Auth::user()->phone ?? 'Muzakki' }}</p>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('zakat.calculator') }}" class="flex items-center gap-3 px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('zakat.calculator') ? 'bg-emerald-600 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Hitung Zakat
                    </a>

                    <a href="{{ route('zakat.pay') }}" class="flex items-center gap-3 px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('zakat.pay') ? 'bg-emerald-600 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Bayar Zakat (QRIS)
                    </a>

                    <a href="{{ route('zakat.history') }}" class="flex items-center gap-3 px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('zakat.history') ? 'bg-emerald-600 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Riwayat Pembayaran
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white' : 'text-emerald-100 hover:bg-emerald-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>

                    @if(Auth::user()->isAdmin())
                    <a href="/admin" class="flex items-center gap-3 px-4 py-3 text-base font-bold rounded-xl bg-amber-500 text-amber-950 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Filament Admin Panel
                    </a>
                    @endif
                </nav>

                <div class="p-4 border-t border-emerald-800">
                    <button @click="logoutModalOpen = true" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600/90 hover:bg-red-600 text-white font-semibold rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Akun
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            <!-- MOBILE TOP HEADER (With Three-Dots Menu Button in Top-Right) -->
            <header class="lg:hidden bg-emerald-900 text-white px-4 py-3.5 flex items-center justify-between shadow-md z-10">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold">
                        BM
                    </div>
                    <span class="font-extrabold text-base tracking-wide">BAITUL MAAL</span>
                </div>

                <!-- 3-DOTS MENU BUTTON ON TOP RIGHT (as requested) -->
                <button @click="mobileMenuOpen = true" type="button" class="p-2 rounded-xl text-emerald-100 hover:text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors" title="Buka Sidebar Menu">
                    <span class="sr-only">Buka Menu Sidebar</span>
                    <!-- Vertical Three Dots Icon -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
            </header>

            <!-- MAIN SCROLLABLE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-sm font-semibold">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-start justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <p class="text-sm font-semibold">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div x-show="logoutModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="logoutModalOpen" x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="logoutModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

        <div x-show="logoutModalOpen" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl z-10 text-center">
            <div class="w-14 h-14 bg-red-100 rounded-2xl mx-auto flex items-center justify-center text-red-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Konfirmasi Keluar</h3>
            <p class="text-sm text-gray-600 mt-2">Apakah Anda yakin ingin keluar dari akun Baitul Maal?</p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" @click="logoutModalOpen = false" class="w-1/2 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="w-1/2">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-md transition">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
