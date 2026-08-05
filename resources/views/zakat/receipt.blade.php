<?php
    $setting = \App\Models\Setting::first();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Sah Penerimaan Zakat - #TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</title>
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

        /* KOP KUITANSI RESMI */
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
        }
        .kop-text h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
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

        .judul-kuitansi {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-kuitansi h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
        }
        .judul-kuitansi p {
            font-size: 11pt;
            margin: 4px 0 0 0;
            font-family: monospace;
        }

        table.kuitansi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        table.kuitansi-table td {
            padding: 8px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }
        .label {
            width: 30%;
            font-weight: bold;
        }
        .titik-dua {
            width: 2%;
            text-align: center;
        }
        .nilai {
            width: 68%;
        }

        .nominal-box {
            border: 2px solid #000;
            padding: 12px;
            font-size: 14pt;
            font-weight: bold;
            margin: 15px 0;
            display: inline-block;
            background-color: #f8f9fa;
        }

        .doa-box {
            border: 1px dashed #000;
            padding: 10px 15px;
            margin: 15px 0;
            text-align: center;
            font-size: 10pt;
        }

        .ttd-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .ttd-box {
            width: 45%;
            text-align: center;
        }
        .ttd-space {
            height: 60px;
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
            <strong>Kuitansi Bukti Sah Penerimaan Zakat</strong><br>
            <span style="font-size: 12px; color: #64748b;">No. Transaksi: #TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div>
            <a href="{{ route('zakat.history') }}" class="btn btn-back">← Kembali</a>
            <button onclick="window.print()" class="btn btn-print">Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- MAIN KUITANSI CONTAINER -->
    <div style="max-width: 800px; margin: 0 auto; border: 1px solid #000; padding: 25px;">

        <!-- KOP SURAT KUITANSI RESMI -->
        <div class="kop-surat">
            <img src="{{ asset('storage/baitul_mal.jpg') }}" class="kop-logo" alt="Logo Instansi" />
            <div class="kop-text">
                <h2>LEMBAGA AMIL ZAKAT RESMI</h2>
                <h1>{{ strtoupper($setting->org_name ?? 'BAITUL MAAL AMIL ZAKAT') }}</h1>
                <p>SK Kemenag RI No. 842/2025 | Terakreditasi A Syariat</p>
                <p>{{ $setting->contact_address ?? 'Jl. Kebajikan No. 99, Jakarta Pusat' }} | Telp: {{ $setting->contact_phone ?? '(021) 8000-ZAKAT' }}</p>
            </div>
        </div>
        <div class="garis-kop-1"></div>
        <div class="garis-kop-2"></div>

        <!-- JUDUL KUITANSI RESMI -->
        <div class="judul-kuitansi">
            <h3>KUITANSI BUKTI SAH PENERIMAAN ZAKAT</h3>
            <p>Nomor Bukti: #TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- RINCIAN KUITANSI TABLE -->
        <table class="kuitansi-table">
            <tr>
                <td class="label">Telah Diterima Dari (Muzakki)</td>
                <td class="titik-dua">:</td>
                <td class="nilai" style="font-weight: bold; font-size: 12pt;">{{ $payment->sender_name }}</td>
            </tr>
            <tr>
                <td class="label">Peruntukan / Jenis Zakat</td>
                <td class="titik-dua">:</td>
                <td class="nilai">{{ $payment->title }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal & Waktu Transaksi</td>
                <td class="titik-dua">:</td>
                <td class="nilai">{{ $payment->created_at->translatedFormat('d F Y, H:i:s') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="titik-dua">:</td>
                <td class="nilai">{{ strtoupper($payment->payment_type ?? 'Midtrans QRIS / Transfer Bank') }}</td>
            </tr>
            <tr>
                <td class="label">Status Verifikasi System</td>
                <td class="titik-dua">:</td>
                <td class="nilai" style="font-weight: bold;">{{ $payment->status }} (Terverifikasi System Webhook)</td>
            </tr>
            @if($payment->notes)
                <tr>
                    <td class="label">Catatan Muzakki</td>
                    <td class="titik-dua">:</td>
                    <td class="nilai">{{ $payment->notes }}</td>
                </tr>
            @endif
        </table>

        <!-- NOMINAL KUITANSI -->
        <div style="text-align: left;">
            <span style="font-weight: bold;">Jumlah Nominal Zakat:</span><br>
            <div class="nominal-box">
                Rp {{ number_format($payment->amount, 0, ',', '.') }}
            </div>
        </div>

        <!-- DOA PENERIMAAN ZAKAT -->
        <div class="doa-box">
            <p style="font-size: 11pt; font-weight: bold; margin-bottom: 4px;">"آجَرَكَ اللهُ فِيمَا أَعْطَيْتَ وَبَارَكَ فِيمَا أَبْقَيْتَ وَجَعَلَهُ لَكَ طَهُورًا"</p>
            <p style="font-style: italic; margin: 0;">"Semoga Allah memberikan pahala atas apa yang engkau berikan, memberkahi apa yang engkau sisakan, dan menjadikannya pembersih bagimu."</p>
        </div>

        <!-- TANDA TANGAN KUITANSI -->
        <div class="ttd-container">
            <div class="ttd-box">
                <p>System Automatic Gateway</p>
                <div class="ttd-space"></div>
                <p style="font-[monospace]; font-size: 9pt;">[ VERIFIED ONLINE MIDTRANS ]</p>
            </div>
            <div class="ttd-box">
                <p>Jakarta, {{ $payment->created_at->translatedFormat('d F Y') }}</p>
                <p style="font-weight: bold;">Bendahara / Petugas Amil Zakat</p>
                <div class="ttd-space"></div>
                <p style="font-weight: bold; text-decoration: underline;">Ahmad Syarifuddin, S.Ak.</p>
                <p style="font-size: 10pt;">NIP. 19920815 201503 1 005</p>
            </div>
        </div>

    </div>

</body>
</html>
