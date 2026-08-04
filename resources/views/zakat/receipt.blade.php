<?php
    $setting = \App\Models\Setting::first();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Bukti Pembayaran Zakat - #TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-card { border: none !important; shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen p-4 sm:p-8 flex items-center justify-center">

    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10 relative overflow-hidden print-card">
        
        <!-- TOP ACTION BAR (No Print) -->
        <div class="no-print mb-8 flex items-center justify-between border-b pb-4">
            <a href="{{ route('zakat.history') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                &larr; Kembali ke Riwayat
            </a>
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-600/30 flex items-center gap-2">
                <span>Cetak / Unduh PDF</span>
            </button>
        </div>

        <!-- HEADER STRUK -->
        <div class="flex items-center justify-between border-b-2 border-emerald-600 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-md">
                    BM
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-wider">BAITUL MAAL</h2>
                    <p class="text-xs text-emerald-600 font-bold">Lembaga Amil Zakat Resmi</p>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-black uppercase rounded-full tracking-wider">BUKTI SAH PENERIMAAN</span>
                <p class="text-xs text-slate-400 mt-1 font-bold">#TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- BODY STRUK -->
        <div class="py-8 space-y-6">
            <div class="text-center space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Telah Diterima Zakat Dari</p>
                <h1 class="text-2xl font-black text-slate-900">{{ $payment->sender_name }}</h1>
            </div>

            <!-- DETAIL TABLE -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 space-y-4">
                <div class="flex justify-between items-center text-sm border-b border-slate-200/60 pb-3">
                    <span class="text-slate-500 font-medium">Peruntukan Zakat</span>
                    <span class="font-extrabold text-slate-900">{{ $payment->title }}</span>
                </div>

                <div class="flex justify-between items-center text-sm border-b border-slate-200/60 pb-3">
                    <span class="text-slate-500 font-medium">Tanggal Transaksi</span>
                    <span class="font-bold text-slate-800">{{ $payment->created_at->format('d M Y, H:i:s') }}</span>
                </div>

                <div class="flex justify-between items-center text-sm border-b border-slate-200/60 pb-3">
                    <span class="text-slate-500 font-medium">Status Verifikasi</span>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                        {{ $payment->status }}
                    </span>
                </div>

                @if($payment->notes)
                    <div class="flex justify-between items-center text-sm border-b border-slate-200/60 pb-3">
                        <span class="text-slate-500 font-medium">Catatan Penyaluran</span>
                        <span class="font-bold text-slate-800">{{ $payment->notes }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center pt-2">
                    <span class="text-base font-extrabold text-slate-900">Total Nominal Zakat</span>
                    <span class="text-2xl font-black text-emerald-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- DOA PENERIMA ZAKAT -->
            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-center space-y-1">
                <p class="text-xs font-bold text-emerald-800 italic">"Aajarakallahu fiimaa a'thaita, wa baaraka fiimaa abqaita, wa ja'alahu laka thahuuraa."</p>
                <p class="text-xs text-emerald-700">Artinya: "Semoga Allah memberikan pahala atas apa yang engkau berikan, memberkahi apa yang engkau sisakan, dan menjadikannya pembersih bagimu."</p>
            </div>
        </div>

        <!-- FOOTER STRUK -->
        <div class="border-t border-slate-200 pt-6 flex items-center justify-between text-xs text-slate-400">
            <div>
                <p class="font-bold text-slate-700">{{ $setting->org_name ?? 'Baitul Maal Amil Zakat' }}</p>
                <p>{{ $setting->contact_address ?? 'Jakarta, Indonesia' }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-slate-700">Dicetak Otomatis</p>
                <p>{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

    </div>

</body>
</html>
