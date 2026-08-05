<?php
    $setting = \App\Models\Setting::first();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Kuitansi Sah Zakat - #TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen p-4 sm:p-8 flex items-center justify-center">

    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl border-2 border-emerald-800/20 p-8 sm:p-10 relative overflow-hidden print-card">
        
        <!-- TOP ACTION BAR (No Print) -->
        <div class="no-print mb-8 flex items-center justify-between border-b border-slate-200 pb-4">
            <a href="{{ route('zakat.history') }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center gap-1">
                <span>&larr; Kembali ke Riwayat Pembayaran</span>
            </a>
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-700/30 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF Struk</span>
            </button>
        </div>

        <!-- HEADER KUITANSI RESMI -->
        <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/baitul_mal.jpg') }}" class="h-14 w-auto rounded-xl object-contain shadow-sm border border-emerald-100" alt="Baitul Maal Logo" />
                <div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight leading-none uppercase">BAITUL MAAL AMIL ZAKAT</h2>
                    <p class="text-[11px] text-emerald-700 font-bold mt-1">Lembaga Amil Zakat Terakreditasi Resmi</p>
                    <p class="text-[10px] text-slate-500 font-medium">{{ $setting->contact_address ?? 'Gedung Baitul Maal, Jakarta' }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-900 text-[10px] font-black uppercase rounded-full tracking-wider border border-emerald-300">
                    BUKTI SAH PENERIMAAN
                </span>
                <p class="text-xs text-slate-500 mt-1 font-mono font-bold">#TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- BODY KUITANSI -->
        <div class="py-6 space-y-6">
            <div class="text-center space-y-1">
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Telah Diterima Zakat Dari</p>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $payment->sender_name }}</h1>
            </div>

            <!-- DETAIL MUTASI TABLE -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-3.5 text-xs">
                <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                    <span class="text-slate-500 font-semibold">Jenis / Peruntukan Zakat</span>
                    <span class="font-extrabold text-slate-900 text-sm">{{ $payment->title }}</span>
                </div>

                <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                    <span class="text-slate-500 font-semibold">Tanggal & Waktu Transaksi</span>
                    <span class="font-bold text-slate-800 font-mono">{{ $payment->created_at->translatedFormat('d F Y, H:i:s') }} WIB</span>
                </div>

                <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                    <span class="text-slate-500 font-semibold">Metode Pembayaran</span>
                    <span class="font-bold text-slate-800 uppercase">{{ $payment->payment_type ?? 'Midtrans QRIS / Transfer' }}</span>
                </div>

                <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                    <span class="text-slate-500 font-semibold">Status Verifikasi System</span>
                    <span class="px-3 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        {{ $payment->status }}
                    </span>
                </div>

                @if($payment->notes)
                    <div class="flex justify-between items-center pb-2.5 border-b border-slate-200">
                        <span class="text-slate-500 font-semibold">Catatan Muzakki</span>
                        <span class="font-bold text-slate-800">{{ $payment->notes }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-black text-slate-900 uppercase tracking-wider">Total Nominal Zakat</span>
                    <span class="text-2xl font-black text-emerald-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- DOA PENERIMAAN ZAKAT -->
            <div class="p-5 bg-emerald-50/80 rounded-2xl border border-emerald-200 text-center space-y-1.5">
                <p class="text-sm font-black text-emerald-900 leading-relaxed font-serif">
                    "آجَرَكَ اللهُ فِيمَا أَعْطَيْتَ وَبَارَكَ فِيمَا أَبْقَيْتَ وَجَعَلَهُ لَكَ طَهُورًا"
                </p>
                <p class="text-xs font-bold text-emerald-800 italic">"Aajarakallahu fiimaa a'thaita, wa baaraka fiimaa abqaita, wa ja'alahu laka thahuuraa."</p>
                <p class="text-[11px] text-emerald-700">Artinya: "Semoga Allah memberikan pahala atas apa yang engkau berikan, memberkahi apa yang engkau sisakan, dan menjadikannya pembersih bagimu."</p>
            </div>
        </div>

        <!-- TANDA TANGAN & STEMPEL AMIL ZAKAT -->
        <div class="pt-4 border-t border-slate-200 grid grid-cols-2 text-center text-xs">
            <div>
                <p class="text-slate-400 text-[10px]">Verifikasi Sistem Midtrans</p>
                <div class="h-16 flex items-center justify-center">
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[10px] rounded uppercase">AUTOMATIC CALLBACK VERIFIED</span>
                </div>
                <p class="font-extrabold text-slate-800">System Gateway</p>
            </div>
            <div>
                <p class="text-slate-500">Jakarta, {{ $payment->created_at->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-slate-900 mt-0.5">Petugas Amil Zakat</p>
                <div class="h-14 flex items-center justify-center">
                    <span class="text-[10px] text-slate-400 italic font-mono">[ Stempel Sah Baitul Maal ]</span>
                </div>
                <p class="font-extrabold text-slate-900 underline">Ahmad Syarifuddin, S.Ak.</p>
                <p class="text-[10px] text-slate-500">NIP. 19920815 201503 1 005</p>
            </div>
        </div>

        <!-- FOOTER KUITANSI -->
        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
            <p>&copy; {{ date('Y') }} Baitul Maal Amil Zakat. Struk Kuitansi SAH Digital.</p>
            <p>Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }} WIB</p>
        </div>

    </div>

</body>
</html>
