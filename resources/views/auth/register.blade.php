<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-emerald-800">Pendaftaran Akun Muzakki</h2>
        <p class="text-sm text-gray-600 mt-1">Lengkapi data diri Anda untuk membuat akun zakat</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Ahmad Abdullah" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="place_of_birth" value="Tempat Lahir" class="font-semibold text-gray-700" />
                <x-text-input id="place_of_birth" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="place_of_birth" :value="old('place_of_birth')" required placeholder="Jakarta" />
                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2 text-sm text-red-600" />
            </div>
            <div>
                <x-input-label for="date_of_birth" value="Tanggal Lahir" class="font-semibold text-gray-700" />
                <x-text-input id="date_of_birth" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <!-- Nomor HP -->
        <div>
            <x-input-label for="phone" value="Nomor HP / WhatsApp" class="font-semibold text-gray-700" />
            <x-text-input id="phone" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="phone" :value="old('phone')" required placeholder="081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Alamat -->
        <div>
            <x-input-label for="address" value="Alamat Lengkap" class="font-semibold text-gray-700" />
            <textarea id="address" name="address" rows="3" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Jl. Merdeka No. 12, RT 01 / RW 02">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password & Konfirmasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" value="Password" class="font-semibold text-gray-700" />
                <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Password" class="font-semibold text-gray-700" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Daftar Sekarang
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
