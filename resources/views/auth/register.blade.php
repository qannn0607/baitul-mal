<x-guest-layout>
    <div class="mb-6 space-y-1">
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pendaftaran Akun Muzakki</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">Lengkapi data diri di bawah ini untuk mendaftar akun zakat.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div class="space-y-1">
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Ahmad Abdullah" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-600 font-medium" />
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <x-input-label for="place_of_birth" value="Tempat Lahir" />
                <x-text-input id="place_of_birth" type="text" name="place_of_birth" :value="old('place_of_birth')" required placeholder="Jakarta" />
                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-1 text-xs text-rose-600 font-medium" />
            </div>
            <div class="space-y-1">
                <x-input-label for="date_of_birth" value="Tanggal Lahir" />
                <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1 text-xs text-rose-600 font-medium" />
            </div>
        </div>

        <!-- Nomor HP -->
        <div class="space-y-1">
            <x-input-label for="phone" value="Nomor HP / WhatsApp" />
            <x-text-input id="phone" type="text" name="phone" :value="old('phone')" required placeholder="081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-rose-600 font-medium" />
        </div>

        <!-- Alamat -->
        <div class="space-y-1">
            <x-input-label for="address" value="Alamat Lengkap" />
            <textarea id="address" name="address" rows="2" class="w-full border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors placeholder:text-slate-400" required placeholder="Jl. Merdeka No. 12, RT 01 / RW 02">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-1 text-xs text-rose-600 font-medium" />
        </div>

        <!-- Password & Konfirmasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" type="password" name="password" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-600 font-medium" />
            </div>
            <div class="space-y-1">
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-600 font-medium" />
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Daftar Akun Sekarang
            </button>
        </div>

        <div class="text-center pt-4 border-t border-slate-100 dark:border-slate-800">
            <p class="text-xs text-slate-600 dark:text-slate-400">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
