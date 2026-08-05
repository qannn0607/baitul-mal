<x-guest-layout>
    <div class="mb-6 space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">Masukkan Nama Lengkap dan Password yang terdaftar.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div class="space-y-1">
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-600 font-medium" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password" name="password" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-600 font-medium" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-emerald-600 focus:ring-emerald-600" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-600 dark:text-slate-400">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Masuk ke Akun
            </button>
        </div>

        <div class="text-center pt-4 border-t border-slate-100 dark:border-slate-800">
            <p class="text-xs text-slate-600 dark:text-slate-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
