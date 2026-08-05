<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan & Penyaluran Zakat - {{ $setting->org_name ?? 'Baitul Maal' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            color: #000000;
            margin: 0;
            padding: 20px;
            font-size: 12pt;
            line-height: 1.4;
        }
        .no-print {
            margin-bottom: 20px;
            padding: 12px;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .btn {
            padding: 8px 16px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #000;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background-color: #000000;
            color: #ffffff;
        }
        .btn-back {
            background-color: #ffffff;
            color: #000000;
        }
        
        /* KOP SURAT PEMERINTAHAN */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }
        .kop-logo {
            position: absolute;
            left: 10px;
            top: 0;
            width: 75px;
            height: 75px;
            object-fit: contain;
        }
        .kop-text h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-text h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .kop-text p {
            font-size: 10pt;
            margin: 2px 0;
        }
        .garis-kop-1 {
            border-top: 3px solid #000000;
            margin-top: 5px;
        }
        .garis-kop-2 {
            border-top: 1px solid #000000;
            margin-top: 2px;
            margin-bottom: 20px;
        }

        /* JUDUL SURAT RESMI */
        .judul-laporan {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-laporan h3 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
        }
        .judul-laporan p {
            font-size: 11pt;
            margin: 4px 0 0 0;
        }

        /* TABEL SURAT KEDINASAN */
        table.table-gov {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        table.table-gov th, table.table-gov td {
            border: 1px solid #000000;
            padding: 6px 8px;
            vertical-align: middle;
        }
        table.table-gov th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .summary-box {
            border: 1px solid #000;
            padding: 12px;
            margin-bottom: 20px;
        }

        /* TANDA TANGAN KEDINASAN */
        .ttd-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .ttd-box {
            width: 45%;
            text-align: center;
        }
        .ttd-space {
            height: 70px;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
        }
    </style>
</head>
<body>

    <!-- Action Bar (No Print) -->
    <div class="no-print">
        <div>
            <strong>Cetak Laporan Keuangan Zakat (Format Kedinasan Resmi)</strong><br>
            <span style="font-size: 12px; color: #64748b;">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</span>
        </div>
        <div>
            <button onclick="window.history.back()" class="btn btn-back">← Kembali</button>
            <button onclick="window.print()" class="btn btn-print">Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- MAIN REPORT DOCUMENT CONTAINER -->
    <div style="max-w: 800px; margin: 0 auto;">

        <!-- KOP SURAT LEMBAGA RESMI -->
        <div class="kop-surat">
            <img src="{{ asset('storage/baitul_mal.jpg') }}" class="kop-logo" alt="Logo Instansi" />
            <div class="kop-text">
                <h2>LEMBAGA AMIL ZAKAT RESMI</h2>
                <h1>{{ strtoupper($setting->org_name ?? 'BAITUL MAAL AMIL ZAKAT') }}</h1>
                <p>Izin Operasional SK Kemenag RI No. 842/2025 | Terakreditasi A</p>
                <p>{{ $setting->contact_address ?? 'Jl. Kebajikan No. 99, Jakarta Pusat' }} | Telp: {{ $setting->contact_phone ?? '(021) 8000-ZAKAT' }} | Email: {{ $setting->contact_email ?? 'layanan@baitulmaal.go.id' }}</p>
            </div>
        </div>
        <div class="garis-kop-1"></div>
        <div class="garis-kop-2"></div>

        <!-- JUDUL LAPORAN KEDINASAN -->
        <div class="judul-laporan">
            <h3>LAPORAN MUTASI KAS & PENYALURAN ZAKAT (8 ASNAF)</h3>
            <p>Nomor: 042/BAITULMAAL/LAP-FIN/{{ date('m/Y') }}</p>
            <p>Periode Laporan: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        </div>

        <!-- SUMMARY STATS BOX -->
        <table class="table-gov">
            <thead>
                <tr>
                    <th>Total Terhimpun (Kredit)</th>
                    <th>Total Disalurkan (Debet)</th>
                    <th>Sisa Saldo Kas Aktif</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center font-bold">
                    <td style="font-size: 13pt;">Rp {{ number_format($totalCollected, 0, ',', '.') }}</td>
                    <td style="font-size: 13pt;">Rp {{ number_format($totalDistributed, 0, ',', '.') }}</td>
                    <td style="font-size: 13pt;">Rp {{ number_format($currentBalance, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- TABEL 1: RINGKASAN ALOKASI 8 ASNAF -->
        <p class="font-bold" style="margin-bottom: 6px;">I. RINCIAN ALOKASI DISTRIBUSI 8 ASNAF MUSTAHIK</p>
        <table class="table-gov">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Kategori 8 Asnaf</th>
                    <th style="width: 40%;">Keterangan Syariat</th>
                    <th style="width: 12%;">Program</th>
                    <th style="width: 18%;">Total Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
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
                    $no = 1;
                @endphp
                @foreach($asnafBreakdown as $category => $data)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="font-bold">{{ $category }}</td>
                        <td>{{ $asnafLabels[$category] ?? '-' }}</td>
                        <td class="text-center">{{ $data['count'] }} Program</td>
                        <td class="text-right font-bold">Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold" style="background-color: #f9f9f9;">
                    <td colspan="4" class="text-center">TOTAL ALOKASI PENYALURAN ZAKAT</td>
                    <td class="text-right">Rp {{ number_format($totalDistributed, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- TABEL 2: RIWAYAT MUTASI BUKU KAS (LEDGER) -->
        <p class="font-bold" style="margin-top: 25px; margin-bottom: 6px;">II. RINCIAN MUTASI BUKU KAS ZAKAT (DOUBLE-ENTRY LEDGER)</p>
        @if($ledgers->isEmpty())
            <p style="font-style: italic; text-align: center; border: 1px solid #000; padding: 10px;">Belum ada mutasi kas pada rentang tanggal ini.</p>
        @else
            <table class="table-gov">
                <thead>
                    <tr>
                        <th style="width: 15%;">Tanggal & Waktu</th>
                        <th style="width: 12%;">Jenis</th>
                        <th style="width: 45%;">Keterangan Mutasi Kas</th>
                        <th style="width: 14%;">Nominal (Rp)</th>
                        <th style="width: 14%;">Saldo Kas (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ledgers as $ledger)
                        <tr>
                            <td class="text-center" style="font-size: 10pt;">{{ $ledger->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center font-bold">
                                {{ $ledger->type === 'credit' ? 'Uang Masuk (+)' : 'Uang Keluar (-)' }}
                            </td>
                            <td>{{ $ledger->description }}</td>
                            <td class="text-right font-bold">
                                {{ $ledger->type === 'credit' ? '+' : '-' }} Rp {{ number_format($ledger->amount, 0, ',', '.') }}
                            </td>
                            <td class="text-right font-bold">
                                Rp {{ number_format($ledger->balance_after, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- TANDA TANGAN SURAT RESMI KEDINASAN -->
        <div class="ttd-container">
            <div class="ttd-box">
                <p>Mengetahui,</p>
                <p class="font-bold">Ketua Pengurus Baitul Maal</p>
                <div class="ttd-space"></div>
                <p class="font-bold" style="text-decoration: underline;">H. Muhammad Rayhan, S.E., M.E.</p>
                <p style="font-size: 10pt;">NIP. 19850412 201001 1 003</p>
            </div>
            <div class="ttd-box">
                <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Bendahara / Amil Zakat</p>
                <div class="ttd-space"></div>
                <p class="font-bold" style="text-decoration: underline;">Ahmad Syarifuddin, S.Ak.</p>
                <p style="font-size: 10pt;">NIP. 19920815 201503 1 005</p>
            </div>
        </div>

    </div>

</body>
</html>
