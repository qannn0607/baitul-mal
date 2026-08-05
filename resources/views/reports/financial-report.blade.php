<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan & Penyaluran Zakat - {{ $setting->org_name ?? 'Baitul Maal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
            }
            .page-break {
                page-break-after: always;
            }
            .shadow-lg, .shadow-sm {
                box-shadow: none !important;
            }
            .border {
                border-color: #cbd5e1 !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 min-h-screen">

    <!-- Action Bar (No Print) -->
    <div class="max-w-5xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-lg font-bold text-slate-800">Cetak Laporan Keuangan Zakat</h1>
            <p class="text-sm text-slate-500">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.history.back()" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                ← Kembali
            </button>
            <button onclick="window.print()" class="px-5 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Main Report Document Container -->
    <div class="max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-2xl border border-slate-200 shadow-lg">

        <!-- KOP SURAT LEMBAGA -->
        <div class="flex items-center justify-between pb-6 border-b-2 border-slate-800">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-extrabold text-2xl shadow-md">
                    BM
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ strtoupper($setting->org_name ?? 'BAITUL MAAL AMIL ZAKAT') }}</h2>
                    <p class="text-xs text-slate-600">{{ $setting->contact_address ?? 'Gedung Baitul Maal Amil Zakat, Jakarta' }}</p>
                    <p class="text-xs text-slate-500">Telepon: {{ $setting->contact_phone ?? '-' }} | Email: {{ $setting->contact_email ?? '-' }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-800 font-bold text-xs rounded-md border border-emerald-200">DOKUMEN RESMI</span>
                <p class="text-xs text-slate-400 mt-1">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- JUDUL LAPORAN -->
        <div class="text-center my-6">
            <h3 class="text-xl font-bold text-slate-900 uppercase tracking-wide">LAPORAN MUTASI KAS & PENYALURAN ZAKAT (8 ASNAF)</h3>
            <p class="text-sm font-medium text-slate-600">Periode Laporan: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        </div>

        <!-- SUMMARY STATS GRID -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-emerald-50/60 p-4 rounded-xl border border-emerald-200">
                <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Total Terhimpun (Credit)</p>
                <p class="text-xl font-extrabold text-emerald-700 mt-1">Rp {{ number_format($totalCollected, 0, ',', '.') }}</p>
            </div>
            <div class="bg-rose-50/60 p-4 rounded-xl border border-rose-200">
                <p class="text-xs font-semibold text-rose-800 uppercase tracking-wider">Total Disalurkan (Debit)</p>
                <p class="text-xl font-extrabold text-rose-700 mt-1">Rp {{ number_format($totalDistributed, 0, ',', '.') }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-300">
                <p class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Sisa Saldo Kas Aktif</p>
                <p class="text-xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($currentBalance, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- TABEL 1: RINGKASAN ALOKASI 8 ASNAF -->
        <div class="mb-8">
            <h4 class="text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-600 rounded-full"></span>
                1. Rincian Alokasi Distribusi 8 Asnaf Mustahik
            </h4>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left border border-slate-200 rounded-lg overflow-hidden">
                    <thead class="bg-slate-100 text-slate-800 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-4 py-2.5 border-b border-slate-200">Kategori 8 Asnaf</th>
                            <th class="px-4 py-2.5 border-b border-slate-200">Keterangan Syariat</th>
                            <th class="px-4 py-2.5 border-b border-slate-200 text-center">Jumlah Program</th>
                            <th class="px-4 py-2.5 border-b border-slate-200 text-right">Total Nominal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 font-medium">
                        @php
                            $asnafLabels = [
                                'Fakir' => 'Sangat Miskin / Tidak Berpenghasilan',
                                'Miskin' => 'Penghasilan Kurang Dari Kebutuhan Pokok',
                                'Amil' => 'Pengelola & Panitia Zakat',
                                'Muallaf' => 'Baru Masuk Islam / Dikuatkan Imannya',
                                'Riqab' => 'Pembebasan Hamba Sahaya / Kemerdekaan',
                                'Gharim' => 'Terlilit Hutang Kebutuhan Pokok',
                                'Fisabilillah' => 'Pejuang Agama, Dakwah & Pendidikan',
                                'Ibnu Sabil' => 'Musafir Kehabisan Bekal Perjalanan',
                            ];
                        @endphp
                        @foreach($asnafBreakdown as $category => $data)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 font-bold text-slate-900">{{ $category }}</td>
                                <td class="px-4 py-2 text-slate-600">{{ $asnafLabels[$category] ?? '-' }}</td>
                                <td class="px-4 py-2 text-center text-slate-800">{{ $data['count'] }} Program</td>
                                <td class="px-4 py-2 text-right font-bold text-slate-900">Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 font-bold border-t-2 border-slate-300">
                        <tr>
                            <td colspan="3" class="px-4 py-2.5 text-slate-900 uppercase">Total Alokasi Penyaluran Zakat</td>
                            <td class="px-4 py-2.5 text-right text-emerald-700">Rp {{ number_format($totalDistributed, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- TABEL 2: RIWAYAT MUTASI BUKU KAS (LEDGER) -->
        <div class="mb-10">
            <h4 class="text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-600 rounded-full"></span>
                2. Rincian Mutasi Buku Kas Zakat (Ledger Table)
            </h4>
            @if($ledgers->isEmpty())
                <p class="text-xs text-slate-500 italic p-4 bg-slate-50 rounded-lg text-center">Belum ada mutasi kas pada rentang tanggal ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border border-slate-200 rounded-lg overflow-hidden">
                        <thead class="bg-slate-100 text-slate-800 uppercase text-[10px] font-bold">
                            <tr>
                                <th class="px-3 py-2 border-b border-slate-200">Tanggal & Waktu</th>
                                <th class="px-3 py-2 border-b border-slate-200">Jenis</th>
                                <th class="px-3 py-2 border-b border-slate-200">Keterangan Mutasi</th>
                                <th class="px-3 py-2 border-b border-slate-200 text-right">Nominal (Rp)</th>
                                <th class="px-3 py-2 border-b border-slate-200 text-right">Saldo Kas (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 font-medium">
                            @foreach($ledgers as $ledger)
                                <tr>
                                    <td class="px-3 py-2 text-slate-600 whitespace-nowrap">{{ $ledger->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @if($ledger->type === 'credit')
                                            <span class="text-emerald-700 font-bold">🟢 Uang Masuk</span>
                                        @else
                                            <span class="text-rose-700 font-bold">🔴 Uang Keluar</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-slate-800">{{ $ledger->description }}</td>
                                    <td class="px-3 py-2 text-right font-bold {{ $ledger->type === 'credit' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $ledger->type === 'credit' ? '+' : '-' }} Rp {{ number_format($ledger->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2 text-right font-bold text-slate-900">
                                        Rp {{ number_format($ledger->balance_after, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- BLOK TANDA TANGAN KETUA AMIL & BENDAHARA -->
        <div class="mt-12 pt-6 border-t border-slate-200 grid grid-cols-2 text-center text-xs">
            <div>
                <p class="text-slate-500">Mengetahui,</p>
                <p class="font-bold text-slate-900 mt-0.5">Ketua Pengurus Baitul Maal</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] text-slate-400 italic">[ Tanda Tangan & Stempel Resmi ]</span>
                </div>
                <p class="font-bold text-slate-900 underline">H. Muhammad Rayhan, S.E., M.E.</p>
                <p class="text-[10px] text-slate-500">NIP. 19850412 201001 1 003</p>
            </div>
            <div>
                <p class="text-slate-500">Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-slate-900 mt-0.5">Bendahara / Amil Zakat</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] text-slate-400 italic">[ Tanda Tangan Resmi ]</span>
                </div>
                <p class="font-bold text-slate-900 underline">Ahmad Syarifuddin, S.Ak.</p>
                <p class="text-[10px] text-slate-500">NIP. 19920815 201503 1 005</p>
            </div>
        </div>

    </div>

</body>
</html>
