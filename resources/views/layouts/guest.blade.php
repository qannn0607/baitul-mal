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

        <!-- Tailwind CSS CDN Fallback & Vite -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-gradient-to-br from-emerald-50 via-slate-50 to-teal-100 min-h-screen text-gray-900 antialiased flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-600 text-white shadow-xl shadow-emerald-200 mb-3">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4m0 4h4m-4-4l-4 4m8-4l4 4"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-emerald-900 tracking-tight">BAITUL MAAL</h1>
            <p class="text-sm font-medium text-emerald-700 mt-1">Sistem Informasi Pengelolaan & Penyaluran Zakat</p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="bg-white/90 backdrop-blur-md py-8 px-6 shadow-2xl rounded-3xl border border-emerald-100 sm:px-10">
                {{ $slot }}
            </div>
            <p class="text-center text-xs text-gray-500 mt-6">&copy; {{ date('Y') }} Baitul Maal. Seluruh hak cipta dilindungi.</p>
        </div>
    </body>
</html>
