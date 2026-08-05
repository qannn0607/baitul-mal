<?php
    $setting = \App\Models\Setting::first();
    $user = Auth::user();
    $payments = $user->payments()->latest()->get();
    $totalAmount = $payments->whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');
    $lastPayment = $payments->first();
?>

<x-app-layout>
    <div class="space-y-8 max-w-7xl mx-auto">
        
        <!-- HEADER WELCOME -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 p-6 sm:p-8 bg-slate-900 text-white rounded-2xl border border-slate-800 shadow-sm">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        Portal Muzakki
                    </span>
                    <span class="text-xs text-slate-400 font-medium">• {{ date('d F Y') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Assalamu'alaikum, {{ $user->name }}</h1>
                <p class="text-slate-400 text-xs sm:text-sm font-normal max-w-xl">
                    Semoga Allah SWT senantiasa memberikan keberkahan atas rezeki dan menyucikan harta yang Anda zakatkan.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('zakat.calculator') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs rounded-xl border border-slate-700 transition-colors">
                    Kalkulator Zakat
                </a>
                <a href="{{ route('zakat.pay') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors">
                    Bayar Zakat Sekarang
                </a>
            </div>
        </div>

        <!-- ANNOUNCEMENT BANNER -->
        @if(!empty($setting->announcement_banner))
            <div class="p-4 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-xs flex items-start gap-3">
                <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                <div class="space-y-0.5 flex-1">
                    <span class="font-semibold text-slate-900 dark:text-white uppercase tracking-wider text-[10px] block">Informasi Baitul Maal</span>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">{{ $setting->announcement_banner }}</p>
                </div>
            </div>
        @endif

        <!-- FINTECH SUMMARY STAT CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Stat 1: Total Zakat -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Zakat Tersalurkan</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
                <div class="space-y-0.5">
                    <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Total transaksi terverifikasi</p>
                </div>
            </div>

            <!-- Stat 2: Status Terakhir -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-2">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Status Transaksi Terakhir</span>
                @if($lastPayment)
                    <div class="space-y-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold
                            {{ $lastPayment->status === 'Sudah Disalurkan' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border border-sky-200 dark:border-sky-800' : '' }}
                            {{ $lastPayment->status === 'Transaksi Sukses' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : '' }}
                            {{ $lastPayment->status === 'Menunggu Verifikasi' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : '' }}
                            {{ $lastPayment->status === 'Ditolak' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800' : '' }}
                        ">
                            {{ $lastPayment->status }}
                        </span>
                        <p class="text-xs font-semibold text-slate-900 dark:text-white truncate pt-1">{{ $lastPayment->title }}</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Rp {{ number_format($lastPayment->amount, 0, ',', '.') }}</p>
                    </div>
                @else
                    <p class="text-xs font-medium text-slate-400 pt-1">Belum ada riwayat transaksi</p>
                @endif
            </div>

            <!-- Stat 3: Nisab Emas -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-2">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Acuan Nisab Emas</span>
                <div class="space-y-0.5">
                    <h3 class="text-xl font-extrabold text-amber-600 dark:text-amber-400 tracking-tight">Rp {{ number_format($setting->nisab_gold_price ?? 1400000, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500 dark:text-slate-400">/ gram</span></h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Nisab 85gr = Rp {{ number_format(($setting->nisab_gold_price ?? 1400000) * 85, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Stat 4: Zakat Fitrah Standard -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-2">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">Standar Zakat Fitrah</span>
                <div class="space-y-0.5">
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($setting->zakat_fitrah_nominal ?? 45000, 0, ',', '.') }} <span class="text-xs font-medium text-slate-500 dark:text-slate-400">/ jiwa</span></h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Setara 2.5 kg beras pokok</p>
                </div>
            </div>

        </div>

        <!-- TRANSPARENCY & 8 ASNAF DISTRIBUTION SECTION -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-5">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border border-sky-200 dark:border-sky-800 uppercase tracking-wider">
                            Transparansi Real-Time
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Laporan Penyaluran Zakat (8 Asnaf)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pertanggungjawaban alokasi distribusi dana zakat secara amanah dan akuntabel.</p>
                </div>
                <div class="flex items-center gap-6 text-xs shrink-0">
                    <div>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Terhimpun</span>
                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400 text-base">Rp {{ number_format($totalCollectedGlobal ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-l border-slate-200 dark:border-slate-800 pl-6">
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Disalurkan</span>
                        <span class="font-extrabold text-sky-600 dark:text-sky-400 text-base">Rp {{ number_format($totalDistributedGlobal ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- 8 ASNAF CARDS GRID -->
            <div class="space-y-3">
                <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Rincian Alokasi 8 Kategori Mustahik</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <?php
                        $asnafDetails = [
                            'Fakir' => ['desc' => 'Sangat Miskin'],
                            'Miskin' => ['desc' => 'Penghasilan Kurang'],
                            'Amil' => ['desc' => 'Pengelola Zakat'],
                            'Muallaf' => ['desc' => 'Baru Masuk Islam'],
                            'Riqab' => ['desc' => 'Memerdekakan Hamba'],
                            'Gharim' => ['desc' => 'Terlilit Hutang Pokok'],
                            'Fisabilillah' => ['desc' => 'Pejuang Agama & Dakwah'],
                            'Ibnu Sabil' => ['desc' => 'Musafir Kehabisan Bekal'],
                        ];
                    ?>
                    @foreach($asnafBreakdown as $name => $amount)
                        <?php $detail = $asnafDetails[$name] ?? ['desc' => 'Mustahik']; ?>
                        <div class="p-4 bg-slate-50/70 dark:bg-slate-800/40 rounded-xl border border-slate-200/70 dark:border-slate-800 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $name }}</span>
                                <span class="text-[10px] font-medium text-slate-400 uppercase">Asnaf</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight">{{ $detail['desc'] }}</p>
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
                    <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Aktivitas Penyaluran Terbaru</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 uppercase font-semibold text-[10px]">
                                    <th class="py-2.5">Tanggal</th>
                                    <th class="py-2.5">Nama Program</th>
                                    <th class="py-2.5">Kategori 8 Asnaf</th>
                                    <th class="py-2.5">Penerima Manfaat</th>
                                    <th class="py-2.5 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                                @foreach($recentDistributions as $dist)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                        <td class="py-3 text-slate-500 dark:text-slate-400 font-medium">
                                            {{ $dist->distribution_date->format('d M Y') }}
                                        </td>
                                        <td class="py-3 font-semibold text-slate-900 dark:text-white">
                                            {{ $dist->program_name }}
                                        </td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                {{ $dist->asnaf }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-slate-600 dark:text-slate-300">
                                            {{ $dist->recipient_name }}
                                        </td>
                                        <td class="py-3 text-right font-bold text-slate-900 dark:text-white">
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
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight">Riwayat Transaksi Pembayaran Saya</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Daftar transaksi pembayaran zakat yang Anda lakukan.</p>
                </div>
                <a href="{{ route('zakat.history') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 uppercase font-semibold text-[10px]">
                                <th class="py-2.5">Tanggal</th>
                                <th class="py-2.5">Peruntukan Zakat</th>
                                <th class="py-2.5">Nominal</th>
                                <th class="py-2.5">Status</th>
                                <th class="py-2.5 text-right">Struk PDF</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($payments->take(5) as $pay)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="py-3 text-slate-500 dark:text-slate-400 font-medium">
                                        {{ $pay->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 font-semibold text-slate-900 dark:text-white">
                                        {{ $pay->title }}
                                    </td>
                                    <td class="py-3 font-bold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-semibold
                                            {{ $pay->status === 'Sudah Disalurkan' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border border-sky-200 dark:border-sky-800' : '' }}
                                            {{ $pay->status === 'Transaksi Sukses' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : '' }}
                                            {{ $pay->status === 'Menunggu Verifikasi' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : '' }}
                                            {{ $pay->status === 'Ditolak' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800' : '' }}
                                        ">
                                            {{ $pay->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        @if(in_array($pay->status, ['Transaksi Sukses', 'Sudah Disalurkan']))
                                            <a href="{{ route('zakat.receipt', $pay->id) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-700 transition-colors">
                                                Struk PDF
                                            </a>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-normal">Proses Verifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-10 space-y-2">
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Belum Ada Riwayat Transaksi</p>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">Anda belum pernah melakukan pembayaran zakat melalui platform Baitul Maal.</p>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
