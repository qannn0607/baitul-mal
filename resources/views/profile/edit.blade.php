<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold rounded-full border border-emerald-300 dark:border-emerald-800">Pengaturan Akun</span>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white mt-2">Profil Saya & Keamanan</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Perbarui data diri, tempat/tanggal lahir, nomor HP, dan ubah kata sandi Anda.</p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-sm font-semibold flex items-center gap-2">
                <span>✅ Data profil Anda berhasil diperbarui!</span>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-sm font-semibold flex items-center gap-2">
                <span>✅ Password Anda berhasil diubah!</span>
            </div>
        @endif

        <!-- Card 1: Informasi Profil -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 dark:border-slate-800 space-y-6">
            <h2 class="text-lg font-black text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3">Informasi Data Diri</h2>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap (Username Login)</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" />
                    @error('name') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="place_of_birth" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tempat Lahir</label>
                        <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $user->place_of_birth) }}" required class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" />
                        @error('place_of_birth') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" />
                        @error('date_of_birth') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- No HP -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nomor HP / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" />
                    @error('phone') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" required class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs rounded-xl shadow-md transition">
                        Simpan Perubahan Data Diri
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Ubah Password -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 dark:border-slate-800 space-y-6" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            <h2 class="text-lg font-black text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-3">Ubah Password Akun</h2>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="update_password_current_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password Saat Ini</label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" id="update_password_current_password" name="current_password" class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 pr-12 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" placeholder="Masukkan password saat ini..." required />
                        <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-xs font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-md">
                            <span x-text="showCurrent ? 'Sembunyikan' : 'Lihat'"></span>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- New Password -->
                    <div>
                        <label for="update_password_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input :type="showNew ? 'text' : 'password'" id="update_password_password" name="password" class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 pr-12 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" placeholder="Masukkan password baru..." required />
                            <button type="button" @click="showNew = !showNew" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-xs font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-md">
                                <span x-text="showNew ? 'Sembunyikan' : 'Lihat'"></span>
                            </button>
                        </div>
                        @error('password', 'updatePassword') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="update_password_password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" id="update_password_password_confirmation" name="password_confirmation" class="w-full rounded-xl border-2 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white px-4 py-3 pr-12 font-semibold focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600 outline-none transition-colors" placeholder="Ulangi password baru..." required />
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-xs font-bold px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-md">
                                <span x-text="showConfirm ? 'Sembunyikan' : 'Lihat'"></span>
                            </button>
                        </div>
                        @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-black text-white font-black text-xs rounded-xl shadow-md transition">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
