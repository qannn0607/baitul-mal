```
  ____   _  _____ _____ _   _ _     __  __    _    _    _     
 | __ ) / \|_   _|  ___| | | | |   |  \/  |  / \  / \  | |    
 |  _ \/ _ \ | | | |_  | | | | |   | |\/| | / _ \/ _ \ | |    
 | |_) / ___ \| | |  _| | |_| | |___| |  | |/ ___ / ___ \| |___ 
 |____/_/   \_\_| |_|    \___/|_____|_|  |_/_/   /_/   \_\_____|
```

# BAITUL MAAL FINANCIAL ENGINE & MUSTAHIK PORTAL

System Version: 2.4.0-STABLE  
Framework: Laravel 11.x (PHP 8.2+)  
Architecture: Double-Entry Ledger & Midtrans Webhook Engine  

---

## Ringkasan Eksekutif

Baitul Maal adalah platform akuntansi zakat terintegrasi yang dirancang untuk mengelola seluruh ekosistem keuangan zakat—mulai dari kalkulasi nisab otomatis, gateway pembayaran digital real-time via Midtrans, pencatatan mutasi kas ganda (Double-Entry Ledger System), hingga verifikasi permohonan bantuan Mustahik berbasis 8 Asnaf dan penerbitan laporan keuangan standar audit dalam format PDF.

---

## Arsitektur & Alur Data Sistem

```
+-------------------+       +-----------------------+       +-------------------------+
|   Muzakki / User  | ----> |   Midtrans Gateway    | ----> |   Webhook Controller    |
| (Input Zakat Maal)|       | (Snap / Dynamic QRIS) |       | (/api/midtrans/notif)   |
+-------------------+       +-----------------------+       +-------------------------+
                                                                         |
                                                                         v
+-------------------+       +-----------------------+       +-------------------------+
| Mustahik Portal   |       |  Double-Entry Ledger  | <---- | Signature Key & Status  |
| (/mustahik/apply) |       | (ZakatFundService)    |       | Verification Engine     |
+-------------------+       +-----------------------+       +-------------------------+
          |                             |
          v                             v
+-------------------------------------------------------------------------------------+
|                     Filament Admin Panel & PDF Financial Report                     |
+-------------------------------------------------------------------------------------+
```

---

## Ringkasan Fitur & Capability Matrix

| Modul Utama | Fitur & Deskripsi | Status Engine |
| :--- | :--- | :--- |
| Zakat Engine | Kalkulator Nisab Emas, Tabungan, Perdagangan, dan Fitrah | ACTIVE |
| Payment Gateway | Midtrans Snap Integration & Dynamic QRIS Payment | ACTIVE |
| Auto-Verification | Webhook Notification Handler dengan SHA512 Signature Check | ACTIVE |
| Core Accounting | Real-Time Double-Entry Ledger (Uang Masuk / Credit & Uang Keluar / Debit) | ACTIVE |
| Safety Mechanism | Overdraft Prevention (Pencegahan Penyaluran Melebihi Saldo) | ACTIVE |
| Mustahik Portal | Permohonan Bantuan Online, Upload SKTM, Tracking Status Real-time | ACTIVE |
| Admin Panel | Filament Dashboard, Approval Action, Audit Logging, User Role Management | ACTIVE |
| Financial Report | Printable Executive PDF Report & Breakdown 8 Kategori Asnaf | ACTIVE |

---

## Spesifikasi API & Endpoint Webhook

### 1. Midtrans Webhook Notification Callback

- Protocol: HTTP POST
- Endpoint: `/api/midtrans/notification`
- Authentication: Excluded CSRF, Signature Key Hash Validation (SHA-512)
- Header: `Content-Type: application/json`

Payload Request (Dari Server Midtrans):
```json
{
  "transaction_status": "settlement",
  "order_id": "TRX-00042",
  "gross_amount": "1500000.00",
  "status_code": "200",
  "signature_key": "a8f...9c2",
  "payment_type": "qris"
}
```

Respon Sistem (Status 200 OK):
```json
{
  "status": "success",
  "message": "Payment verified and recorded into Zakat Ledger"
}
```

Mekanisme Internal Webhook:
1. Sistem menghitung Hash SHA512: `SHA512(order_id + status_code + gross_amount + ServerKey)`.
2. Jika Signature cocok dan status `settlement` atau `capture`:
   - Mengubah status tabel `payments` menjadi `Transaksi Sukses`.
   - Mengisi `verified_at` dan `payment_method`.
   - Menjalankan `ZakatFundService::recordPaymentCredit()` untuk menambah transaksi Uang Masuk pada `zakat_ledgers`.

---

### 2. Katalog Endpoint Aplikasi (Routing Table)

#### A. Autentikasi & Portal Muzakki

| Method | Endpoint Route | Middleware | Controller Action | Fungsi & Response |
| :--- | :--- | :--- | :--- | :--- |
| GET | `/` | Guest/Auth | Closure | Landing page perkenalan platform & transparansi publik |
| GET | `/dashboard` | auth | `ZakatController@dashboard` | Dashboard Muzakki, summary saldo, & distribusi 8 asnaf |
| GET | `/hitung-zakat` | auth | `ZakatController@calculator` | Interface kalkulator nisab zakat Maal & Fitrah |
| GET | `/bayar-zakat` | auth | `ZakatController@pay` | Form pembayaraan zakat online |
| POST | `/bayar-zakat` | auth | `ZakatController@storePay` | Generasi Snap Token Midtrans & reservasi transaksi |
| GET | `/riwayat-pembayaran` | auth | `ZakatController@history` | Tabel histori pembayaran zakat milik user |
| GET | `/riwayat-pembayaran/check/{payment}` | auth | `ZakatController@checkStatus` | Manual ping status transaksi ke API Midtrans |
| GET | `/struk/{payment}` | auth | `ZakatController@receipt` | Tampilan kuitansi digital bukti pembayaran sah |

#### B. Portal Layanan Mustahik

| Method | Endpoint Route | Middleware | Controller Action | Fungsi & Response |
| :--- | :--- | :--- | :--- | :--- |
| GET | `/mustahik/apply` | auth | `MustahikApplicationController@apply` | Form pengajuan permohonan zakat online |
| POST | `/mustahik/apply` | auth | `MustahikApplicationController@storeApply` | Upload SKTM/KTP & penyimpanan permohonan |
| GET | `/mustahik/my-applications` | auth | `MustahikApplicationController@myApplications` | Tracking status verifikasi & keputusan Amil |

#### C. Laporan Keuangan & Admin Panel

| Method | Endpoint Route | Middleware | Controller Action | Fungsi & Response |
| :--- | :--- | :--- | :--- | :--- |
| GET | `/reports/financial/print` | auth | `ExportReportController@financialReport` | Cetak PDF Laporan Mutasi Kas & Breakdown 8 Asnaf |
| GET | `/admin/*` | auth (admin) | Filament Panel | Dashboard admin, kelola pembayaran, penyaluran, & ledger |

---

## Skema Database & Relasi Tabel

```
  +------------------+         +------------------+         +------------------+
  |      users       |         |     payments     |         |  distributions   |
  +------------------+         +------------------+         +------------------+
  | id (PK)          | <-----+ | id (PK)          |         | id (PK)          |
  | name             |         | user_id (FK)     |         | program_name     |
  | email            |         | amount           |         | asnaf            |
  | role             |         | payment_type     |         | recipient_name   |
  | created_at       |         | status           |         | amount           |
  +------------------+         | snap_token       |         | distributed_by   |
                               +------------------+         +------------------+
                                        |                            |
                                        v                            v
                               +-----------------------------------------------+
                               |                 zakat_ledgers                 |
                               +-----------------------------------------------+
                               | id (PK)                                       |
                               | type ('credit' | 'debit')                     |
                               | amount                                        |
                               | balance_after                                 |
                               | description                                   |
                               | payment_id (FK, Nullable)                     |
                               | distribution_id (FK, Nullable)                |
                               +-----------------------------------------------+
```

---

## Panduan Deployment & Instalasi

### 1. Persyaratan Sistem
- Docker Engine 24.x+ & Docker Compose v2.x+
- Git 2.x+

### 2. Langkah Instalasi Lingkungan Lokal

Kloning repositori proyek:
```bash
git clone git@github.com:qannn0607/baitul-mal.git
cd baitul-mal
```

Jalankan container aplikasi dengan Docker Compose:
```bash
docker compose up -d --build
```

Jalankan migrasi database dan penyemaian data awal:
```bash
docker compose exec app php artisan migrate:fresh --seed
```

Pengaturan Symlink Storage (Media & Berkas SKTM):
```bash
docker compose exec app php artisan storage:link
```

---

## Pengujian Otomatis (Automated Test Suite)

Sistem ini dilengkapi dengan unit test dan feature test komprehensif yang mencakup seluruh alur transaksi, enkripsi webhook, kalkulasi saldo ledger, hingga otorisasi admin.

Perintah Menjalankan Test Suite:
```bash
docker compose exec app php artisan test
```

Hasil Pengujian Terakhir:
```
PASS  Tests\Unit\ExampleTest
PASS  Tests\Feature\AdminPanelTest
PASS  Tests\Feature\Auth\AuthenticationTest
PASS  Tests\Feature\Auth\EmailVerificationTest
PASS  Tests\Feature\Auth\PasswordConfirmationTest
PASS  Tests\Feature\Auth\PasswordResetTest
PASS  Tests\Feature\Auth\PasswordUpdateTest
PASS  Tests\Feature\Auth\RegistrationTest
PASS  Tests\Feature\DistributionTest
PASS  Tests\Feature\ExampleTest
PASS  Tests\Feature\FinancialReportTest
PASS  Tests\Feature\MidtransPaymentTest
PASS  Tests\Feature\MustahikApplicationTest
PASS  Tests\Feature\ProfileTest
PASS  Tests\Feature\ZakatTest

Tests: 47 passed (99 assertions)
Duration: 4.09s
Status: ALL PASSED (100%)
```

---

## Lisensi & Kontribusi

Pengembangan sistem Baitul Maal dilakukan secara privat untuk pengelolaan dana zakat yang transparan dan profesional. Hak cipta dilindungi undang-undang.