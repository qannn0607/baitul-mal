<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::updateOrCreate(
            ['name' => 'Admin Baitul Maal'],
            [
                'email' => 'admin@baitulmaal.org',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '1990-01-01',
                'phone' => '081234567890',
                'address' => 'Jl. Baitul Maal No. 1, Jakarta Selatan',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Petugas User
        $petugas = User::updateOrCreate(
            ['name' => 'Petugas Zakat'],
            [
                'email' => 'petugas@baitulmaal.org',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '1995-05-15',
                'phone' => '081298765432',
                'address' => 'Jl. Masjid Agung No. 12, Bandung',
                'role' => 'petugas',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Muzakki User
        $user = User::updateOrCreate(
            ['name' => 'Ahmad Abdullah'],
            [
                'email' => 'ahmad@example.com',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '1992-08-17',
                'phone' => '085711223344',
                'address' => 'Jl. Pemuda No. 45, Surabaya',
                'role' => 'user',
                'password' => Hash::make('password'),
            ]
        );

        // 4. Default Setting
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'qris_image' => 'qris/sample.png',
                'nisab_gold_price' => 1400000,
                'zakat_fitrah_nominal' => 45000,
                'announcement_banner' => 'Selamat datang di Sistem Informasi Zakat Baitul Maal. Salurkan zakat Anda secara aman, cepat, dan transparan.',
                'bank_accounts' => [
                    [
                        'bank_name' => 'Bank Syariah Indonesia (BSI)',
                        'account_number' => '7123-4567-89',
                        'account_name' => 'Baitul Maal Amil Zakat',
                    ],
                    [
                        'bank_name' => 'Bank Muamalat',
                        'account_number' => '124-000-5678',
                        'account_name' => 'Baitul Maal Amil Zakat',
                    ],
                ],
                'org_name' => 'Baitul Maal Amil Zakat',
                'org_description' => 'Lembaga Amil Zakat Terpercaya untuk Penghimpunan dan Penyaluran Zakat, Infaq, dan Sedekah secara Efektif dan Transparan.',
                'contact_phone' => '+62 812-3456-7890',
                'contact_email' => 'layanan@baitulmaal.org',
                'contact_address' => 'Gedung Baitul Maal, Lt. 2, Jl. Kebajikan No. 99, Jakarta',
                'footer_text' => '© 2026 Baitul Maal Amil Zakat. Seluruh Hak Cipta Dilindungi.',
            ]
        );

        // 5. Sample Payments
        Payment::updateOrCreate(
            ['id' => 1],
            [
                'user_id' => $user->id,
                'sender_name' => 'Ahmad Abdullah',
                'title' => 'Zakat Penghasilan',
                'amount' => 250000,
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Sudah Disalurkan',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(5),
                'distributed_at' => now()->subDays(2),
                'notes' => 'Telah disalurkan kepada 5 Mustahik Fakir Miskin di Wilayah Jakarta.',
            ]
        );

        Payment::updateOrCreate(
            ['id' => 2],
            [
                'user_id' => $user->id,
                'sender_name' => 'Ahmad Abdullah',
                'title' => 'Zakat Maal',
                'amount' => 1500000,
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Transaksi Sukses',
                'verified_by' => $petugas->id,
                'verified_at' => now()->subDays(1),
                'notes' => 'Transaksi sukses diverifikasi oleh petugas.',
            ]
        );

        Payment::updateOrCreate(
            ['id' => 3],
            [
                'user_id' => $user->id,
                'sender_name' => 'Ahmad Abdullah',
                'title' => 'Zakat Fitrah',
                'amount' => 90000,
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Menunggu Verifikasi',
                'notes' => null,
            ]
        );

        // 6. Sample Audit Logs
        AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'Verifikasi Pembayaran',
            'description' => 'Admin memverifikasi pembayaran Zakat Penghasilan sebesar Rp 250.000 dari Ahmad Abdullah.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
        ]);

        AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'Penyaluran Zakat',
            'description' => 'Admin menandai Zakat Penghasilan #1 sebagai Sudah Disalurkan.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0',
        ]);
    }
}
