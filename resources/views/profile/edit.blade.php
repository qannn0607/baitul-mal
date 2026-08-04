<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Pengaturan Akun</span>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Profil Saya & Keamanan</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui data diri, tempat/tanggal lahir, nomor HP, dan ubah kata sandi Anda.</p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold">
                ✅ Data profil Anda berhasil diperbarui!
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold">
                ✅ Password Anda berhasil diubah!
            </div>
        @endif

        <!-- Card 1: Informasi Profil -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b pb-3">Informasi Data Diri</h2>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap (Username Login)</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold" />
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="place_of_birth" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tempat Lahir</label>
                        <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $user->place_of_birth) }}" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold" />
                        @error('place_of_birth') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold" />
                        @error('date_of_birth') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- No HP -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor HP / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold" />
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" required class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 font-semibold">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Ubah Password -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b pb-3">Ubah Password Akun</h2>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password Saat Ini</label>
                    <input type="password" id="update_password_current_password" name="current_password" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" required />
                    @error('current_password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="update_password_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password Baru</label>
                        <input type="password" id="update_password_password" name="password" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" required />
                        @error('password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="update_password_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                        <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" required />
                        @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-md transition">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
