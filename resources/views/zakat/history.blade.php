<?php
    $midtransJsUrl = ($isProduction ?? false) 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
?>

<x-app-layout>
    @if(!empty($clientKey))
        <script src="{{ $midtransJsUrl }}" data-client-key="{{ $clientKey }}"></script>
    @endif

    <div class="max-w-6xl mx-auto space-y-8" 
         x-data="{
             searchQuery: '',
             statusFilter: 'all',
             previewModalOpen: false,
             previewImageUrl: '',
             previewTitle: '',

             openPreview(url, title) {
                 this.previewImageUrl = url;
                 this.previewTitle = title;
                 this.previewModalOpen = true;
             },

             paySnap(token) {
                 if (window.snap && token) {
                     window.snap.pay(token, {
                         onSuccess: function(result) {
                             fetch('/api/midtrans/notification', {
                                 method: 'POST',
                                 headers: {
                                     'Content-Type': 'application/json',
                                     'Accept': 'application/json',
                                 },
                                 body: JSON.stringify({
                                     order_id: result.order_id,
                                     status_code: result.status_code || '200',
                                     gross_amount: result.gross_amount,
                                     transaction_status: 'settlement'
                                 })
                             }).finally(function() {
                                 window.location.href = '{{ route('zakat.history') }}';
                             });
                         },
                         onPending: function(result) {
                             window.location.href = '{{ route('zakat.history') }}';
                         },
                         onError: function(result) {
                             window.location.href = '{{ route('zakat.history') }}';
                         },
                         onClose: function() {
                             window.location.href = '{{ route('zakat.history') }}';
                         }
                     });
                 }
             },

             init() {
                 @if(!empty($activeSnapToken))
                     if (window.history && window.history.replaceState) {
                         window.history.replaceState({}, document.title, window.location.pathname);
                     }
                     this.paySnap('{{ $activeSnapToken }}');
                 @endif
             }
         }">

        <!-- HEADER TITLE -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    Arsip & Status Zakat
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Riwayat Pembayaran Zakat</h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Pantau status verifikasi dan bukti penyaluran zakat Anda.</p>
            </div>
            <a href="{{ route('zakat.pay') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors self-start sm:self-auto">
                + Setor Zakat Baru
            </a>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row gap-4 justify-between items-center">
            
            <!-- Search Input -->
            <div class="w-full sm:w-80">
                <input type="text" x-model="searchQuery" placeholder="Cari transaksi / pengirim..." class="w-full px-4 py-2 bg-slate-50/50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-medium text-xs focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-colors">
            </div>

            <!-- Status Filter Buttons -->
            <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto">
                <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700'" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                    Semua
                </button>
                <button @click="statusFilter = 'Menunggu Verifikasi'" :class="statusFilter === 'Menunggu Verifikasi' ? 'bg-amber-600 text-white' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 hover:bg-amber-100'" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                    Menunggu
                </button>
                <button @click="statusFilter = 'Transaksi Sukses'" :class="statusFilter === 'Transaksi Sukses' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-100'" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                    Sukses
                </button>
                <button @click="statusFilter = 'Sudah Disalurkan'" :class="statusFilter === 'Sudah Disalurkan' ? 'bg-sky-600 text-white' : 'bg-sky-50 dark:bg-sky-950/40 text-sky-800 dark:text-sky-300 hover:bg-sky-100'" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors">
                    Disalurkan
                </button>
            </div>

        </div>

        <!-- TRANSACTIONS TABLE CARD -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-xs">
            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 uppercase font-semibold text-[10px]">
                                <th class="py-3">ID & Tanggal</th>
                                <th class="py-3">Peruntukan Zakat</th>
                                <th class="py-3">Nominal</th>
                                <th class="py-3">Metode / Resi</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($payments as $pay)
                                <tr x-show="(statusFilter === 'all' || statusFilter === '{{ $pay->status }}') && ('{{ strtolower($pay->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($pay->sender_name) }}'.includes(searchQuery.toLowerCase()))" 
                                    class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                    
                                    <td class="py-3.5">
                                        <p class="font-bold text-slate-900 dark:text-white">#TRX-{{ str_pad($pay->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">{{ $pay->created_at->format('d M Y, H:i') }}</p>
                                    </td>

                                    <td class="py-3.5">
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $pay->title }}</p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Pengirim: {{ $pay->sender_name }}</p>
                                    </td>

                                    <td class="py-3.5 font-bold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="py-3.5">
                                        @if(!empty($pay->proof_image))
                                            <button @click="openPreview('{{ Storage::url($pay->proof_image) }}', '{{ $pay->title }}')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-[11px] font-semibold rounded-lg text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors">
                                                Lihat Resi
                                            </button>
                                        @else
                                            <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">Midtrans Gateway</span>
                                        @endif
                                    </td>

                                    <td class="py-3.5">
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-semibold
                                                {{ $pay->status === 'Sudah Disalurkan' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border border-sky-200 dark:border-sky-800' : '' }}
                                                {{ $pay->status === 'Transaksi Sukses' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : '' }}
                                                {{ $pay->status === 'Menunggu Verifikasi' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : '' }}
                                                {{ $pay->status === 'Ditolak' ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800' : '' }}
                                            ">
                                                {{ $pay->status }}
                                            </span>
                                            @if($pay->status === 'Ditolak' && $pay->rejection_reason)
                                                <p class="text-[11px] text-rose-500 font-medium">Alasan: {{ $pay->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-3.5 text-right">
                                        @if(in_array($pay->status, ['Transaksi Sukses', 'Sudah Disalurkan']))
                                            <a href="{{ route('zakat.receipt', $pay->id) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-semibold rounded-lg shadow-xs transition-colors">
                                                Struk PDF
                                            </a>
                                        @elseif($pay->status === 'Menunggu Verifikasi' && !empty($pay->snap_token))
                                            <div class="inline-flex items-center gap-2 justify-end">
                                                <a href="{{ route('zakat.check', $pay->id) }}" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-[11px] font-semibold rounded-lg border border-slate-200 dark:border-slate-700 transition-colors" title="Sinkronkan status dari Midtrans Gateway">
                                                    Cek Status
                                                </a>
                                                <button @click="paySnap('{{ $pay->snap_token }}')" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-semibold rounded-lg shadow-xs transition-colors">
                                                    Bayar Sekarang
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-normal">Menunggu Verifikasi</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 space-y-2">
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Belum Ada Transaksi Pembayaran</p>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">Riwayat pembayaran zakat Anda akan ditampilkan di sini setelah Anda melakukan transaksi.</p>
                </div>
            @endif
        </div>

        <!-- IMAGE PREVIEW MODAL -->
        <div x-show="previewModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="previewModalOpen" x-transition:enter="transition-opacity ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="previewModalOpen = false" class="fixed inset-0 bg-slate-950/70"></div>

            <div x-show="previewModalOpen" x-transition:enter="transition ease-out duration-150 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white dark:bg-slate-900 border dark:border-slate-800 rounded-2xl p-6 max-w-lg w-full shadow-xl z-10 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="'Bukti Transfer: ' + previewTitle"></h3>
                    <button @click="previewModalOpen = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-sm">
                        ✕
                    </button>
                </div>
                <div class="bg-slate-50 dark:bg-slate-950 p-2 rounded-xl border border-slate-200 dark:border-slate-800">
                    <img :src="previewImageUrl" alt="Preview Resi" class="w-full max-h-96 object-contain rounded-lg">
                </div>
                <div class="text-right">
                    <button @click="previewModalOpen = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold text-xs rounded-xl">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
