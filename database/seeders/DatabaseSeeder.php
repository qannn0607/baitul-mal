<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use App\Services\ZakatFundService;
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

        // 5. Sync Zakat Fund Ledger Balance (Reset to 0 if clean)
        ZakatFundService::recalculateBalance();
    }
}
