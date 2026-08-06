<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Form Pengajuan Bantuan Zakat Mustahik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 text-slate-900 dark:text-slate-200">
                
                <div class="mb-8 pb-6 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/baitul_mal.jpg') }}" class="w-10 h-10 rounded-xl object-contain shadow-sm" alt="Baitul Maal Logo" />
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Permohonan Bantuan Zakat (Mustahik)</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Layanan penerimaan permohonan bantuan zakat transparan dan akuntabel bagi 8 Asnaf yang berhak.</p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-700 rounded-xl">
                        <h4 class="text-sm font-bold text-rose-800 dark:text-rose-200 mb-2">Mohon perbaiki kesalahan berikut:</h4>
                        <ul class="list-disc list-inside text-xs text-rose-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mustahik.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{
                        amountRequestedDisplay: '{{ old('amount_requested') ? number_format(old('amount_requested'), 0, ',', '.') : '' }}',
                        amountRequested: '{{ old('amount_requested', '') }}',
                        formatAmount(value) {
                            const number = value.replace(/[^0-9]/g, '');
                            this.amountRequested = number;
                            this.amountRequestedDisplay = number ? parseInt(number).toLocaleString('id-ID') : '';
                        },
                        submitForm() {
                            if (this.$refs.amountRequestedInput) {
                                this.$refs.amountRequestedInput.value = this.amountRequested;
                            }
                        }
                    }" @submit="submitForm" novalidate>
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pemohon -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Nama Lengkap Pemohon (Sesuai KTP) <span class="text-rose-500">*</span></label>
                            <input type="text" name="applicant_name" value="{{ old('applicant_name', Auth::user()->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" placeholder="Nama lengkap Anda">
                        </div>

                        <!-- NIK KTP -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">NIK KTP (16 Digit) <span class="text-rose-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" placeholder="Contoh: 3171012345670001">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomor Telepon / WA -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Nomor HP / WhatsApp Aktif <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" placeholder="Contoh: 081234567890">
                        </div>

                        <!-- Kategori 8 Asnaf -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Kategori 8 Asnaf Permohonan <span class="text-rose-500">*</span></label>
                            <select name="asnaf_category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium">
                                <option value="" disabled selected>-- Pilih Kategori 8 Asnaf --</option>
                                <option value="Fakir" {{ old('asnaf_category') == 'Fakir' ? 'selected' : '' }}>🔴 Fakir (Sangat Miskin / Tidak Berpenghasilan)</option>
                                <option value="Miskin" {{ old('asnaf_category') == 'Miskin' ? 'selected' : '' }}>🟡 Miskin (Penghasilan Kurang dari Kebutuhan)</option>
                                <option value="Gharim" {{ old('asnaf_category') == 'Gharim' ? 'selected' : '' }}>🟠 Gharim (Terlilit Hutang Kebutuhan Pokok)</option>
                                <option value="Fisabilillah" {{ old('asnaf_category') == 'Fisabilillah' ? 'selected' : '' }}>❇️ Fisabilillah (Pejuang Agama / Dakwah / Santri)</option>
                                <option value="Ibnu Sabil" {{ old('asnaf_category') == 'Ibnu Sabil' ? 'selected' : '' }}>🌐 Ibnu Sabil (Musafir Kehabisan Bekal)</option>
                                <option value="Muallaf" {{ old('asnaf_category') == 'Muallaf' ? 'selected' : '' }}>🟢 Muallaf (Baru Masuk Islam)</option>
                                <option value="Amil" {{ old('asnaf_category') == 'Amil' ? 'selected' : '' }}>🔵 Amil (Pengelola Zakat)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Program Bantuan -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Jenis Program Bantuan <span class="text-rose-500">*</span></label>
                            <select name="program_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium">
                                <option value="" disabled selected>-- Pilih Jenis Program Bantuan --</option>
                                <option value="Bantuan Paket Sembako / Bahan Pangan">Bantuan Paket Sembako / Bahan Pangan</option>
                                <option value="Bantuan Pengobatan & Kesehatan Darurat">Bantuan Pengobatan & Kesehatan Darurat</option>
                                <option value="Beasiswa Pendidikan Santri / Pelajar Dhuafa">Beasiswa Pendidikan Santri / Pelajar Dhuafa</option>
                                <option value="Bantuan Modal Usaha Kecil Dhuafa">Bantuan Modal Usaha Kecil Dhuafa</option>
                                <option value="Bantuan Pelunasan Hutang Pokok (Gharim)">Bantuan Pelunasan Hutang Pokok (Gharim)</option>
                                <option value="Bantuan Bekal Musafir (Ibnu Sabil)">Bantuan Bekal Musafir (Ibnu Sabil)</option>
                            </select>
                        </div>

                        <!-- Nominal Pengajuan -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Nominal Pengajuan Bantuan (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sm font-bold text-slate-500 dark:text-slate-400">Rp</span>
                                <input type="text" x-model="amountRequestedDisplay" @input="formatAmount($event.target.value)" placeholder="Contoh: 500.000" class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium">
                                <input type="hidden" name="amount_requested" x-ref="amountRequestedInput" :value="amountRequested">
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Alamat Domisili Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="address" rows="2" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" placeholder="Alamat jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten">{{ old('address', Auth::user()->address) }}</textarea>
                    </div>

                    <!-- Alasan Permohonan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Alasan & Rincian Kebutuhan Permohonan <span class="text-rose-500">*</span></label>
                        <textarea name="reason" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" placeholder="Jelaskan secara singkat kondisi kebutuhan permohonan Anda (misal: permohonan bantuan biaya tunggakan SPP sekolah / biaya pengobatan rawat inap)...">{{ old('reason') }}</textarea>
                    </div>

                    <!-- Upload KTP / SKTM -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Upload Foto KTP / Surat Keterangan Tidak Mampu (SKTM) <span class="text-rose-500">*</span></label>
                        <input type="file" name="sktm_proof_image" accept="image/*,.pdf" required class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Format gambar JPG, PNG (Maksimal 5MB).</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('mustahik.my_applications') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition-colors">
                            Lihat Permohonan Saya
                        </a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-colors flex items-center gap-2">
                            <span>Kirim Pengajuan Bantuan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
