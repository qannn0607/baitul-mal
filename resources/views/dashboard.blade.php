<?php
    $setting = \App\Models\Setting::first();
    $user = Auth::user();
    $payments = $user->payments()->latest()->get();
    $totalAmount = $payments->whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');
    $lastPayment = $payments->first();
?>

<x-app-layout>
    <div class="space-y-6">
        
        <!-- HEADER WELCOME -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-900 text-white p-6 rounded-xl border border-slate-800 shadow-xs">
            <div class="space-y-1">
                <span class="px-2.5 py-0.5 bg-emerald-600/30 text-emerald-400 text-[11px] font-bold rounded uppercase tracking-wider">Dashboard Muzakki</span>
                <h1 class="text-xl sm:text-2xl font-bold text-white">Assalamu'alaikum, {{ $user->name }}</h1>
                <p class="text-slate-400 text-xs font-medium">Semoga Allah SWT menyucikan harta dan memberkahi rezeki Anda.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('zakat.calculator') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-lg transition-colors border border-slate-700">
                    Hitung Zakat
                </a>
                <a href="{{ route('zakat.pay') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs transition-colors">
                    Bayar Zakat
                </a>
            </div>
        </div>

        <!-- ANNOUNCEMENT BANNER -->
        @if(!empty($setting->announcement_banner))
            <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200 shadow-xs text-xs space-y-1">
                <h4 class="font-bold uppercase tracking-wider text-[11px] text-amber-800 dark:text-amber-300">Pengumuman Baitul Maal</h4>
                <p class="opacity-90 leading-relaxed">{{ $setting->announcement_banner }}</p>
            </div>
        @endif

        <!-- FINTECH SUMMARY CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: Total Dana Tersalurkan -->
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-1">
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Total Tuntas Zakat</span>
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Transaksi sukses & tersalurkan</p>
            </div>

            <!-- Card 2: Status Terakhir -->
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-1">
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Status Terakhir</span>
                @if($lastPayment)
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[11px] font-bold inline-block
                            {{ $lastPayment->status === 'Sudah Disalurkan' ? 'bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300' : '' }}
                            {{ $lastPayment->status === 'Transaksi Sukses' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                            {{ $lastPayment->status === 'Menunggu Verifikasi' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : '' }}
                            {{ $lastPayment->status === 'Ditolak' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : '' }}
                        ">
                            {{ $lastPayment->status }}
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium truncate">{{ $lastPayment->title }} • Rp {{ number_format($lastPayment->amount, 0, ',', '.') }}</p>
                @else
                    <h3 class="text-xs font-bold text-slate-400">Belum ada transaksi</h3>
                @endif
            </div>

            <!-- Card 3: Nisab Emas Saat Ini -->
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-1">
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Harga Nisab Emas</span>
                <h3 class="text-lg font-extrabold text-amber-600 dark:text-amber-400">Rp {{ number_format($setting->nisab_gold_price ?? 1400000, 0, ',', '.') }} / gr</h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Nisab 85gr = Rp {{ number_format(($setting->nisab_gold_price ?? 1400000) * 85, 0, ',', '.') }}</p>
            </div>

            <!-- Card 4: Zakat Fitrah Standard -->
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-1">
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Zakat Fitrah / Jiwa</span>
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Rp {{ number_format($setting->zakat_fitrah_nominal ?? 45000, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Setara 2.5 kg beras baik</p>
            </div>

        </div>

        <!-- TRANSPARENCY & 8 ASNAF DISTRIBUTION SECTION -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <span class="px-2 py-0.5 bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300 text-[10px] font-bold rounded uppercase tracking-wider">Transparansi Real-Time</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Laporan Penyaluran Zakat (8 Asnaf)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pertanggungjawaban distribusi zakat secara amanah dan terbuka.</p>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Total Terhimpun</span>
                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400 text-sm">Rp {{ number_format($totalCollectedGlobal ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-right border-l border-slate-200 dark:border-slate-800 pl-4">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Total Disalurkan</span>
                        <span class="font-extrabold text-sky-600 dark:text-sky-400 text-sm">Rp {{ number_format($totalDistributedGlobal ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- 8 ASNAF CARDS GRID -->
            <div>
                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">Distribusi Alokasi 8 Asnaf</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <?php
                        $asnafDetails = [
                            'Fakir' => ['color' => 'rose', 'desc' => 'Sangat Miskin'],
                            'Miskin' => ['color' => 'amber', 'desc' => 'Penghasilan Kurang'],
                            'Amil' => ['color' => 'sky', 'desc' => 'Pengelola Zakat'],
                            'Muallaf' => ['color' => 'emerald', 'desc' => 'Baru Masuk Islam'],
                            'Riqab' => ['color' => 'purple', 'desc' => 'Memerdekakan Hamba'],
                            'Gharim' => ['color' => 'orange', 'desc' => 'Terlilit Hutang'],
                            'Fisabilillah' => ['color' => 'teal', 'desc' => 'Pejuang Agama'],
                            'Ibnu Sabil' => ['color' => 'indigo', 'desc' => 'Musafir Kehabisan Bekal'],
                        ];
                    ?>
                    @foreach($asnafBreakdown as $name => $amount)
                        <?php $detail = $asnafDetails[$name] ?? ['color' => 'slate', 'desc' => 'Mustahik']; ?>
                        <div class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200/60 dark:border-slate-800 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $name }}</span>
                                <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">Asnaf</span>
                            </div>
                            <p class="text-[10px] text-slate-400">{{ $detail['desc'] }}</p>
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white pt-1">
                                Rp {{ number_format($amount, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RECENT DISTRIBUTIONS LOG TABLE -->
            @if(isset($recentDistributions) && $recentDistributions->count() > 0)
                <div class="space-y-3 pt-2">
                    <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Aktivitas Penyaluran Terakhir</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500 uppercase font-bold text-[10px]">
                                    <th class="pb-2">Tanggal</th>
                                    <th class="pb-2">Nama Program</th>
                                    <th class="pb-2">8 Asnaf</th>
                                    <th class="pb-2">Mustahik / Penerima</th>
                                    <th class="pb-2 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                @foreach($recentDistributions as $dist)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="py-2.5 text-slate-500 dark:text-slate-400 font-medium">
                                            {{ $dist->distribution_date->format('d M Y') }}
                                        </td>
                                        <td class="py-2.5 font-bold text-slate-900 dark:text-white">
                                            {{ $dist->program_name }}
                                        </td>
                                        <td class="py-2.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                                {{ $dist->asnaf }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 text-slate-700 dark:text-slate-300">
                                            {{ $dist->recipient_name }}
                                        </td>
                                        <td class="py-2.5 text-right font-extrabold text-sky-600 dark:text-sky-400">
                                            Rp {{ number_format($dist->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>

        <!-- RECENT TRANSACTIONS TABLE -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Aktivitas Pembayaran Terbaru</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Daftar transaksi pembayaran zakat Anda.</p>
                </div>
                <a href="{{ route('zakat.history') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500 uppercase font-bold text-[10px]">
                                <th class="pb-2.5">Tanggal</th>
                                <th class="pb-2.5">Kategori</th>
                                <th class="pb-2.5">Nominal</th>
                                <th class="pb-2.5">Status</th>
                                <th class="pb-2.5 text-right">Struk PDF</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($payments->take(5) as $pay)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="py-3 font-medium text-slate-500 dark:text-slate-400">
                                        {{ $pay->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 font-bold text-slate-900 dark:text-white">
                                        {{ $pay->title }}
                                    </td>
                                    <td class="py-3 font-extrabold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold
                                            {{ $pay->status === 'Sudah Disalurkan' ? 'bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300' : '' }}
                                            {{ $pay->status === 'Transaksi Sukses' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                                            {{ $pay->status === 'Menunggu Verifikasi' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : '' }}
                                            {{ $pay->status === 'Ditolak' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : '' }}
                                        ">
                                            {{ $pay->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        @if(in_array($pay->status, ['Transaksi Sukses', 'Sudah Disalurkan']))
                                            <a href="{{ route('zakat.receipt', $pay->id) }}" target="_blank" class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold rounded hover:bg-emerald-100 transition-colors">
                                                Unduh PDF
                                            </a>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">Proses Verifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 space-y-1">
                    <p class="text-xs font-bold text-slate-600 dark:text-slate-400">Belum Ada Transaksi Pembayaran</p>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">Anda belum memiliki riwayat pembayaran zakat.</p>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
