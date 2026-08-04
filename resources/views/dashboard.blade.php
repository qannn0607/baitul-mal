<x-app-layout>
    <div class="space-y-6">
        <!-- Header Welcome -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <span class="px-3 py-1 bg-emerald-700/60 backdrop-blur-sm text-emerald-200 text-xs font-semibold rounded-full uppercase tracking-wider">Dashboard Muzakki</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Assalamu'alaikum, {{ Auth::user()->name }} 👋</h1>
                <p class="text-emerald-100 text-sm mt-1 max-w-xl">Selamat datang di Portal Digital Baitul Maal. Kelola zakat, infaq, dan donasi Anda secara akurat, mudah, dan transparan.</p>
                
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a href="{{ route('zakat.pay') }}" class="px-5 py-2.5 bg-emerald-400 hover:bg-emerald-300 text-emerald-950 font-bold rounded-xl shadow-lg hover:shadow-emerald-400/30 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Bayar Zakat Sekarang
                    </a>
                    <a href="{{ route('zakat.calculator') }}" class="px-5 py-2.5 bg-emerald-900/60 hover:bg-emerald-800/80 text-white font-semibold rounded-xl border border-emerald-700/60 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Hitung Nisab Zakat
                    </a>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-56 h-56 rounded-full bg-emerald-700/20 blur-2xl pointer-events-none"></div>
        </div>

        <!-- STATS WIDGETS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Total Paid -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Terverifikasi</p>
                    <p class="text-xl font-bold text-slate-900 mt-0.5">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Menunggu Verifikasi -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Verifikasi</p>
                    <p class="text-xl font-bold text-amber-600 mt-0.5">{{ $pendingCount }} Transaksi</p>
                </div>
            </div>

            <!-- Diverifikasi -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Diverifikasi</p>
                    <p class="text-xl font-bold text-emerald-600 mt-0.5">{{ $verifiedCount }} Transaksi</p>
                </div>
            </div>

            <!-- Sudah Disalurkan -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sudah Disalurkan</p>
                    <p class="text-xl font-bold text-blue-600 mt-0.5">{{ $distributedCount }} Transaksi</p>
                </div>
            </div>
        </div>

        <!-- RECENT TRANSACTIONS TABLE -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Riwayat Pembayaran Terbaru</h3>
                    <p class="text-xs text-slate-500">Status verifikasi pembayaran zakat Anda</p>
                </div>
                <a href="{{ route('zakat.history') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($recentPayments->isEmpty())
                <!-- EMPTY STATE -->
                <div class="py-12 text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full mx-auto flex items-center justify-center text-emerald-500 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800">Belum Ada Pembayaran Zakat</h4>
                    <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1">Anda belum pernah mengirimkan pembayaran zakat. Tunaikan kewajiban zakat Anda dengan mudah via QRIS.</p>
                    <a href="{{ route('zakat.pay') }}" class="inline-flex items-center gap-2 mt-5 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition">
                        Bayar Zakat Sekarang
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Pengirim</th>
                                <th class="py-3 px-4">Peruntukan</th>
                                <th class="py-3 px-4">Nominal</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Struk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @foreach($recentPayments as $payment)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="py-3.5 px-4 font-medium text-slate-600">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $payment->sender_name }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-semibold text-xs">
                                            {{ $payment->title }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-emerald-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
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
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('zakat.receipt', $payment->id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-800 hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Struk
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
