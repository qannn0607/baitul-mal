<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Bukti Pembayaran Zakat - #{{ $payment->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-card { shadow: none !important; border: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border border-slate-200 print-card space-y-6">

        <!-- Top Actions (No Print) -->
        <div class="no-print flex items-center justify-between border-b pb-4">
            <a href="{{ route('zakat.history') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1">
                &larr; Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </button>
        </div>

        <!-- Receipt Header -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white mx-auto flex items-center justify-center font-extrabold text-xl shadow-lg shadow-emerald-200">
                BM
            </div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">BAITUL MAAL</h2>
            <p class="text-xs font-semibold text-emerald-700 uppercase tracking-widest">Bukti Penerimaan Zakat Digital</p>
            <p class="text-xs text-slate-400">No. Transaksi: #BM-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Divider -->
        <div class="border-t border-dashed border-slate-300 my-4"></div>

        <!-- Details List -->
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-500 font-medium">Tanggal Transaksi</span>
                <span class="text-slate-900 font-bold">{{ $payment->created_at->format('d M Y, H:i') }} WIB</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500 font-medium">Nama Muzakki/Pengirim</span>
                <span class="text-slate-900 font-bold text-right">{{ $payment->sender_name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500 font-medium">Jenis / Peruntukan</span>
                <span class="text-emerald-700 font-bold">{{ $payment->title }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500 font-medium">Status Verifikasi</span>
                <span>
                    @if($payment->status === 'Menunggu Verifikasi')
                        <span class="font-bold text-amber-600">🟡 Menunggu Verifikasi</span>
                    @elseif($payment->status === 'Diverifikasi')
                        <span class="font-bold text-emerald-600">🟢 Diverifikasi</span>
                    @elseif($payment->status === 'Sudah Disalurkan')
                        <span class="font-bold text-blue-600">🔵 Sudah Disalurkan</span>
                    @else
                        <span class="font-bold text-red-600">🔴 Ditolak</span>
                    @endif
                </span>
            </div>

            @if($payment->notes)
            <div class="p-3 bg-slate-50 rounded-xl text-xs text-slate-600 border">
                <strong>Catatan Penyaluran:</strong> {{ $payment->notes }}
            </div>
            @endif
        </div>

        <!-- Divider -->
        <div class="border-t border-dashed border-slate-300 my-4"></div>

        <!-- Total Amount -->
        <div class="bg-emerald-50 rounded-2xl p-4 text-center border border-emerald-100">
            <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Total Nominal Zakat</p>
            <p class="text-3xl font-extrabold text-emerald-700 mt-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        </div>

        <!-- Footer Prayer -->
        <div class="text-center text-xs text-slate-500 space-y-1 pt-2">
            <p class="italic font-medium text-emerald-900">"Aajarakallahu fiima a'thaita, wa baaraka fiima abqaita, wa ja'alahu laka thahuuraa."</p>
            <p class="text-[10px] text-slate-400">Semoga Allah memberi pahala atas apa yang engkau berikan, dan memberkahi apa yang engkau sisakan, serta menjadikannya pembersih bagimu.</p>
        </div>

    </div>

</body>
</html>
