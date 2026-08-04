<?php

namespace Database\Seeders;

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
        $admin = User::firstOrCreate(
            ['name' => 'Admin Baitul Maal'],
            [
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '1990-01-01',
                'phone' => '081234567890',
                'address' => 'Jl. Masjid Agung No. 1, Jakarta Pusat',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Regular Muzakki User
        $user = User::firstOrCreate(
            ['name' => 'Ahmad Abdullah'],
            [
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '1995-05-15',
                'phone' => '089876543210',
                'address' => 'Jl. Merdeka No. 123, Bandung',
                'role' => 'user',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Default Settings
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'qris_image' => null,
                'nisab_gold_price' => 1400000,
                'zakat_fitrah_nominal' => 45000,
            ]
        );

        // 4. Sample Payments
        Payment::firstOrCreate(
            ['sender_name' => 'Ahmad Abdullah', 'amount' => 2500000],
            [
                'user_id' => $user->id,
                'title' => 'Zakat Maal',
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Diverifikasi',
                'verified_at' => now(),
            ]
        );

        Payment::firstOrCreate(
            ['sender_name' => 'Ahmad Abdullah', 'amount' => 500000],
            [
                'user_id' => $user->id,
                'title' => 'Zakat Penghasilan',
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Sudah Disalurkan',
                'verified_at' => now()->subDay(),
                'distributed_at' => now(),
                'notes' => 'Telah disalurkan kepada 50 Mustahik Fakir Miskin di Kecamatan Coblong.',
            ]
        );

        Payment::firstOrCreate(
            ['sender_name' => 'Ahmad Abdullah', 'amount' => 150000],
            [
                'user_id' => $user->id,
                'title' => 'Zakat Fitrah',
                'proof_image' => 'payment_proofs/sample.png',
                'status' => 'Menunggu Verifikasi',
            ]
        );
    }
}
