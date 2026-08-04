<x-app-layout>
    <div class="space-y-6">

        <!-- Header Title & Filters -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Riwayat Transaksi</span>
                <h1 class="text-2xl font-bold text-slate-900 mt-2">Riwayat Pembayaran Zakat</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar seluruh transaksi pembayaran zakat dan status penyalurannya.</p>
            </div>

            <!-- Status Filters -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('zakat.history') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl transition {{ empty($statusFilter) ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Status
                </a>
                <a href="{{ route('zakat.history', ['status' => 'Menunggu Verifikasi']) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl transition {{ $statusFilter === 'Menunggu Verifikasi' ? 'bg-amber-500 text-white shadow-md' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    🟡 Menunggu Verifikasi
                </a>
                <a href="{{ route('zakat.history', ['status' => 'Diverifikasi']) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl transition {{ $statusFilter === 'Diverifikasi' ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    🟢 Diverifikasi
                </a>
                <a href="{{ route('zakat.history', ['status' => 'Sudah Disalurkan']) }}" class="px-3.5 py-2 text-xs font-bold rounded-xl transition {{ $statusFilter === 'Sudah Disalurkan' ? 'bg-blue-600 text-white shadow-md' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                    🔵 Sudah Disalurkan
                </a>
            </div>
        </div>

        <!-- TRANSACTIONS TABLE & LIST -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            @if($payments->isEmpty())
                <!-- EMPTY STATE -->
                <div class="py-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl mx-auto flex items-center justify-center text-slate-400 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-800">Tidak Ada Pembayaran Ditemukan</h4>
                    <p class="text-xs text-slate-500 max-w-xs mx-auto mt-1">Belum ada riwayat pembayaran zakat dengan filter ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="py-3 px-4">Tanggal & Waktu</th>
                                <th class="py-3 px-4">Nama Pengirim</th>
                                <th class="py-3 px-4">Peruntukan Zakat</th>
                                <th class="py-3 px-4">Nominal</th>
                                <th class="py-3 px-4">Status Verifikasi</th>
                                <th class="py-3 px-4 text-center">Bukti Transfer</th>
                                <th class="py-3 px-4 text-right">Aksi / Struk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3.5 px-4 font-medium text-slate-600">
                                        {{ $payment->created_at->format('d M Y') }}
                                        <span class="block text-xs text-slate-400">{{ $payment->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $payment->sender_name }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-semibold text-xs">
                                            {{ $payment->title }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-extrabold text-emerald-700">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($payment->status === 'Menunggu Verifikasi')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                🟡 Menunggu Verifikasi
                                            </span>
                                        @elseif($payment->status === 'Diverifikasi')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                🟢 Diverifikasi
                                            </span>
                                        @elseif($payment->status === 'Sudah Disalurkan')
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                🔵 Sudah Disalurkan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                🔴 Ditolak
                                            </span>
                                        @endif

                                        @if($payment->notes)
                                            <p class="text-xs text-slate-500 italic mt-1 max-w-xs">Catatan: {{ $payment->notes }}</p>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($payment->proof_image)
                                            <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-emerald-600 font-semibold">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('zakat.receipt', $payment->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            Cetak Struk
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
