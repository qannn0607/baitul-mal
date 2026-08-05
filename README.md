# Baitul Maal - Sistem Informasi Pengelolaan Zakat & Penyaluran 8 Asnaf

Baitul Maal adalah platform akuntansi zakat digital berbasis web yang dirancang untuk mengelola penerimaan, kalkulasi, verifikasi pembayaran real-time, serta penyaluran dana zakat secara transparan dan akuntabel sesuai dengan standar syariat 8 Asnaf Mustahik.

Sistem ini dilengkapi dengan integrasi Payment Gateway Midtrans (Snap & Dynamic QRIS Webhook Callback), Buku Kas Zakat (Double-Entry Ledger System), Portal Permohonan Bantuan Mustahik Online, serta Modul Ekspor Laporan Keuangan Resmi berbasis PDF.

---

## Teknologi yang Digunakan

- Framework Backend: Laravel 11 (PHP 8.2+)
- Panel Admin: Filament v3
- Database: MySQL / MariaDB
- Styling & Frontend: Tailwind CSS & Alpine.js
- Payment Gateway: Midtrans Snap & Webhook Notification API
- Containerization: Docker & Docker Compose

---

## Fitur Utama Sistem

1. Hitung & Pembayaran Zakat Real-Time:
   - Kalkulator otomatis Zakat Maal (Emas, Tabungan, Perdagangan) & Zakat Fitrah berbasis standar nisab.
   - Integrasi Midtrans Snap & QRIS otomatis.
   - Webhook Callback dengan verifikasi Signature Key untuk pembaruan status transaksi secara instan tanpa perlu unggah bukti manual.

2. Buku Kas Zakat (Real-Time Double-Entry Ledger):
   - Pencatatan otomatis transaksi Uang Masuk (Credit) saat pembayaran sukses.
   - Pencatatan otomatis transaksi Uang Keluar (Debit) saat dana disalurkan ke Mustahik.
   - Pembaruan saldo terhimpun secara real-time dengan validasi pencegahan saldo minus (Server-Side Overdraft Prevention).

3. Portal Pengajuan Bantuan Mustahik:
   - Layanan permohonan bantuan zakat online bagi calon Mustahik (upload NIK KTP dan SKTM).
   - Sistem pelacakan status permohonan secara real-time (Menunggu Verifikasi, Disetujui, Telah Disalurkan, Ditolak).
   - Integrasi langsung dengan modul penyaluran zakat Admin.

4. Laporan Keuangan Resmi & Cetak PDF:
   - Rekapitulasi mutasi kas periode tertentu.
   - Rincian alokasi distribusi berdasarkan 8 Kategori Asnaf Mustahik (Fakir, Miskin, Amil, Muallaf, Riqab, Gharim, Fisabilillah, Ibnu Sabil).
   - Tampilan dokumen print-ready lengkap dengan Kop Surat Lembaga, Tanggal Cetak, serta Stempel/Tanda Tangan Pengurus & Bendahara.

5. Audit Log & Keamanan Sistem:
   - Pencatatan otomatis setiap aktivitas penting pengurus/admin (Audit Log).
   - Verifikasi otentikasi berbasis Breeze & Role-Based Access Control (Admin, Petugas, Muzakki).

---

## Daftar Endpoint & API

Berikut adalah seluruh daftar rute HTTP, metode, middleware, dan fungsi kegunaannya:

### 1. Web Callback & API Public

- Method: POST
- Endpoint: /api/midtrans/notification
- Middleware: Excluded CSRF Validation
- Action: App\Http\Controllers\Api\PaymentCallbackController@handleNotification
- Kegunaan: Menerima payload webhook dari server Midtrans. Melakukan dekripsi dan verifikasi Signature Key (SHA512). Jika status transaksi bernilai settlement/capture, sistem memperbarui status pembayaran ke "Transaksi Sukses" dan mencatat transaksi Uang Masuk (Credit) pada Buku Kas Zakat secara otomatis.

### 2. Autentikasi & Navigasi Utama

- Method: GET
- Endpoint: /
- Action: Closure (Landing Page / Redirect Dashboard)
- Kegunaan: Menampilkan halaman utama landing page untuk pengunjung non-login, atau mengalihkan user terautentikasi ke /dashboard.

- Method: GET
- Endpoint: /dashboard
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@dashboard
- Kegunaan: Menampilkan ringkasan saldo kas zakat, statistik alokasi 8 Asnaf, status transaksi terakhir, dan riwayat penyaluran terbaru bagi Muzakki.

### 3. Kalkulator & Pembayaran Zakat

- Method: GET
- Endpoint: /hitung-zakat
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@calculator
- Kegunaan: Menampilkan form kalkulasi nisab Zakat Maal (Emas/Tabungan/Perdagangan) dan Zakat Fitrah.

- Method: GET
- Endpoint: /bayar-zakat
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@pay
- Kegunaan: Menampilkan halaman checkout pembayaran zakat (pilihan Midtrans QRIS atau Transfer Bank).

- Method: POST
- Endpoint: /bayar-zakat
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@storePay
- Kegunaan: Memproses data pembayaran zakat baru, membuat record pembayaran, dan menghasilkan Midtrans Snap Token untuk pembayaran online.

- Method: GET
- Endpoint: /riwayat-pembayaran
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@history
- Kegunaan: Menampilkan daftar riwayat pembayaran zakat milik akun yang sedang login.

- Method: GET
- Endpoint: /riwayat-pembayaran/check/{payment}
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@checkStatus
- Kegunaan: Memeriksa status transaksi pembayaran secara manual ke API Server Midtrans dan mengupdate status lokal jika sudah terbayar.

- Method: GET
- Endpoint: /struk/{payment}
- Middleware: auth
- Action: App\Http\Controllers\ZakatController@receipt
- Kegunaan: Menampilkan dan mencetak bukti pembayaran sah (struk kuitansi zakat).

### 4. Permohonan Bantuan Mustahik

- Method: GET
- Endpoint: /mustahik/apply
- Middleware: auth
- Action: App\Http\Controllers\MustahikApplicationController@apply
- Kegunaan: Menampilkan form pengajuan permohonan bantuan zakat online bagi Mustahik.

- Method: POST
- Endpoint: /mustahik/apply
- Middleware: auth
- Action: App\Http\Controllers\MustahikApplicationController@storeApply
- Kegunaan: Mengunggah berkas SKTM/KTP, memvalidasi input, dan menyimpan permohonan ke database dengan status "Menunggu Verifikasi".

- Method: GET
- Endpoint: /mustahik/my-applications
- Middleware: auth
- Action: App\Http\Controllers\MustahikApplicationController@myApplications
- Kegunaan: Menampilkan daftar permohonan bantuan yang pernah diajukan beserta status verifikasi dari Amil.

### 5. Laporan Keuangan & Cetak PDF

- Method: GET
- Endpoint: /reports/financial/print
- Middleware: auth
- Action: App\Http\Controllers\ExportReportController@financialReport
- Kegunaan: Menyusun rekapitulasi mutasi kas, saldo terhimpun, saldo disalurkan, dan rincian alokasi 8 Asnaf ke dalam bentuk halaman dokumen PDF yang siap dicetak.

### 6. Admin Panel (Filament Dashboard)

- Path Base: /admin
- Middleware: auth (Role Admin / Petugas)
- Resources:
  - /admin/payments: Pengelolaan dan verifikasi manual transaksi pembayaran zakat.
  - /admin/distributions: Pengelolaan penyaluran dana zakat ke Mustahik per kategori Asnaf (dilengkapi validasi cek saldo).
  - /admin/zakat-ledgers: Audit trail mutasi buku kas zakat (Credit & Debit).
  - /admin/mustahik-applications: Verifikasi, persetujuan, penolakan, dan aksi penyaluran permohonan bantuan Mustahik.
  - /admin/users: Pengelolaan akun pengguna dan role hak akses.
  - /admin/settings: Pengaturan parameter sistem, nisab emas, nominal zakat fitrah, dan QRIS statis.
  - /admin/audit-logs: Log pencatatan aktivitas audit trail.

---

## Struktur Database Utama

- users: Data akun pengurus, petugas, dan muzakki.
- payments: Data transaksi penerimaan zakat dari Muzakki.
- distributions: Data penyaluran zakat ke Mustahik berdasarkan 8 Asnaf.
- zakat_ledgers: Buku kas umum pencatatan mutasi kas (Credit/Debit).
- mustahik_applications: Data pengajuan bantuan Mustahik online beserta berkas pendukung.
- settings: Parameter konfigurasi organisasi dan acuan nisab zakat.
- audit_logs: Catatan jejak audit aktivitas administrator.

---

## Panduan Instalasi & Jalankan Sistem

1. Clone Repository:
   git clone git@github.com:qannn0607/baitul-mal.git
   cd baitul-mal

2. Jalankan Environment Docker:
   docker compose up -d --build

3. Migration & Seeder Database:
   docker compose exec app php artisan migrate:fresh --seed

4. Akses Aplikasi:
   - Web App: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin

---

## Pengujian Otomatis (Testing)

Jalankan perintah pengujian fitur dan unit test untuk memastikan seluruh modul berfungsi dengan benar:

docker compose exec app php artisan test

Seluruh 47 pengujian fitur (Payment, Ledger, Distribution, Mustahik, Report Export, Admin Panel) telah dinyatakan lulus (PASS).