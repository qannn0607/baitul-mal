<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Baitul Maal') }} - Autentikasi Zakat</title>

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
    <body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen antialiased flex flex-col justify-between py-8 px-4 sm:px-6 lg:px-8 transition-colors duration-200">
        
        <!-- Header area with logo & theme toggle -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md flex items-center justify-between">
            <a href="/" class="flex items-center">
                <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-10 w-auto rounded-xl object-contain shadow-sm" alt="Baitul Maal Logo" />
            </a>

            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 transition-colors">
                <template x-if="darkMode">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </template>
                <template x-if="!darkMode">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </template>
            </button>
        </div>

        <!-- Main Card Container -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md my-auto">
            <div class="bg-white dark:bg-slate-900 py-7 px-6 sm:px-8 shadow-sm border border-slate-200 dark:border-slate-800 rounded-2xl">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer Footer -->
        <div class="text-center text-xs text-slate-500 dark:text-slate-500">
            &copy; {{ date('Y') }} Baitul Maal. Seluruh hak cipta dilindungi.
        </div>

    </body>
</html>
