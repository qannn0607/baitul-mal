<?php
    $midtransJsUrl = ($isProduction ?? false) 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
?>

<x-app-layout>
    @if(!empty($clientKey))
        <script src="{{ $midtransJsUrl }}" data-client-key="{{ $clientKey }}"></script>
    @endif

    <div class="space-y-6" 
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
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Riwayat Pembayaran Zakat</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pantau status verifikasi dan penyaluran zakat Anda.</p>
            </div>
            <a href="{{ route('zakat.pay') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors flex items-center gap-1.5 self-start sm:self-auto">
                <span>+ Bayar Zakat Baru</span>
            </a>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <div class="bg-white dark:bg-slate-900 p-3.5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row gap-3 justify-between items-center">
            
            <!-- Search input -->
            <div class="w-full sm:w-80">
                <input type="text" x-model="searchQuery" placeholder="Cari judul / nama pengirim..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white font-medium text-xs focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
            </div>

            <!-- Status Filter Buttons -->
            <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto">
                <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                    Semua
                </button>
                <button @click="statusFilter = 'Menunggu Verifikasi'" :class="statusFilter === 'Menunggu Verifikasi' ? 'bg-amber-600 text-white' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                    Menunggu
                </button>
                <button @click="statusFilter = 'Transaksi Sukses'" :class="statusFilter === 'Transaksi Sukses' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                    Sukses
                </button>
                <button @click="statusFilter = 'Sudah Disalurkan'" :class="statusFilter === 'Sudah Disalurkan' ? 'bg-sky-600 text-white' : 'bg-sky-50 dark:bg-sky-950/40 text-sky-800 dark:text-sky-300'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                    Disalurkan
                </button>
            </div>

        </div>

        <!-- TRANSACTIONS LIST -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-xs">
            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500 uppercase font-bold text-[10px]">
                                <th class="pb-2.5">Tanggal & ID</th>
                                <th class="pb-2.5">Peruntukan Zakat</th>
                                <th class="pb-2.5">Nominal</th>
                                <th class="pb-2.5">Bukti Resi / Gateway</th>
                                <th class="pb-2.5">Status</th>
                                <th class="pb-2.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @foreach($payments as $pay)
                                <tr x-show="(statusFilter === 'all' || statusFilter === '{{ $pay->status }}') && ('{{ strtolower($pay->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($pay->sender_name) }}'.includes(searchQuery.toLowerCase()))" 
                                    class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    
                                    <td class="py-3">
                                        <p class="font-bold text-slate-900 dark:text-white">#TRX-{{ str_pad($pay->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $pay->created_at->format('d M Y, H:i') }}</p>
                                    </td>

                                    <td class="py-3">
                                        <p class="font-bold text-slate-900 dark:text-white">{{ $pay->title }}</p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Pengirim: {{ $pay->sender_name }}</p>
                                    </td>

                                    <td class="py-3 font-extrabold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="py-3">
                                        @if(!empty($pay->proof_image))
                                            <button @click="openPreview('{{ Storage::url($pay->proof_image) }}', '{{ $pay->title }}')" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-[11px] font-bold rounded text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                                Lihat Resi
                                            </button>
                                        @else
                                            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Midtrans Online</span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        <div class="space-y-0.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold inline-block
                                                {{ $pay->status === 'Sudah Disalurkan' ? 'bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300' : '' }}
                                                {{ $pay->status === 'Transaksi Sukses' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                                                {{ $pay->status === 'Menunggu Verifikasi' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : '' }}
                                                {{ $pay->status === 'Ditolak' ? 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' : '' }}
                                            ">
                                                {{ $pay->status }}
                                            </span>
                                            @if($pay->status === 'Ditolak' && $pay->rejection_reason)
                                                <p class="text-[11px] text-rose-500 font-medium">Alasan: {{ $pay->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-3 text-right">
                                        @if(in_array($pay->status, ['Transaksi Sukses', 'Sudah Disalurkan']))
                                            <a href="{{ route('zakat.receipt', $pay->id) }}" target="_blank" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded shadow-xs inline-flex items-center gap-1 transition-colors">
                                                Cetak PDF
                                            </a>
                                        @elseif($pay->status === 'Menunggu Verifikasi' && !empty($pay->snap_token))
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <a href="{{ route('zakat.check', $pay->id) }}" class="px-2.5 py-1 bg-sky-100 hover:bg-sky-200 dark:bg-sky-950 dark:hover:bg-sky-900 text-sky-800 dark:text-sky-300 text-[11px] font-bold rounded transition-colors" title="Sinkronkan status dari Midtrans Gateway">
                                                    Cek Status
                                                </a>
                                                <button @click="paySnap('{{ $pay->snap_token }}')" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded shadow-xs transition-colors">
                                                    Bayar Sekarang
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">Menunggu Verifikasi</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 space-y-1">
                    <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Belum Ada Transaksi Pembayaran</p>
                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">Riwayat pembayaran zakat Anda akan ditampilkan di sini.</p>
                </div>
            @endif
        </div>

        <!-- IMAGE PREVIEW MODAL -->
        <div x-show="previewModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="previewModalOpen" x-transition:enter="transition-opacity ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="previewModalOpen = false" class="fixed inset-0 bg-slate-950/70"></div>

            <div x-show="previewModalOpen" x-transition:enter="transition ease-out duration-150 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white dark:bg-slate-900 border dark:border-slate-800 rounded-xl p-5 max-w-lg w-full shadow-xl z-10 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white" x-text="'Bukti Transfer: ' + previewTitle"></h3>
                    <button @click="previewModalOpen = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        ✕
                    </button>
                </div>
                <div class="bg-slate-50 dark:bg-slate-950 p-2 rounded-lg border border-slate-200 dark:border-slate-800">
                    <img :src="previewImageUrl" alt="Preview Resi" class="w-full max-h-96 object-contain rounded">
                </div>
                <div class="text-right">
                    <button @click="previewModalOpen = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-lg">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
