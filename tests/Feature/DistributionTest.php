<?php

namespace Tests\Feature;

use App\Filament\Resources\DistributionResource;
use App\Models\Distribution;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_distributions_resource_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/distributions');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_distribution_record(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $distribution = Distribution::create([
            'program_name' => 'Bantuan Beasiswa Pendidikan Santri',
            'asnaf' => 'Fisabilillah',
            'recipient_name' => 'Santri Rumah Tahfidz',
            'amount' => 1000000,
            'distribution_date' => now()->toDateString(),
            'notes' => 'Penyaluran zakat untuk pendidikan santri dhuafa.',
            'distributed_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('distributions', [
            'id' => $distribution->id,
            'program_name' => 'Bantuan Beasiswa Pendidikan Santri',
            'asnaf' => 'Fisabilillah',
            'amount' => 1000000,
        ]);
    }

    public function test_available_balance_calculation_only_includes_successful_payments(): void
    {
        $user = User::factory()->create();

        // Transaksi Sukses Rp 1.000.000
        Payment::create([
            'user_id' => $user->id,
            'sender_name' => 'Muzakki A',
            'title' => 'Zakat Maal',
            'amount' => 1000000,
            'status' => 'Transaksi Sukses',
        ]);

        // Transaksi Menunggu Verifikasi Rp 500.000 (tidak boleh dihitung ke saldo tersedia)
        Payment::create([
            'user_id' => $user->id,
            'sender_name' => 'Muzakki B',
            'title' => 'Zakat Maal',
            'amount' => 500000,
            'status' => 'Menunggu Verifikasi',
        ]);

        // Distribution yang sudah dilakukan Rp 300.000
        Distribution::create([
            'program_name' => 'Program A',
            'asnaf' => 'Fakir',
            'recipient_name' => 'Fakir 1',
            'amount' => 300000,
            'distribution_date' => now()->toDateString(),
        ]);

        // Sisa saldo tersedia harus 1.000.000 - 300.000 = 700.000
        $availableBalance = DistributionResource::getAvailableBalance();
        $this->assertEquals(700000, $availableBalance);
    }

    public function test_user_dashboard_renders_transparency_8_asnaf_section(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        Distribution::create([
            'program_name' => 'Paket Sembako Fakir',
            'asnaf' => 'Fakir',
            'recipient_name' => 'Ibu Maryam',
            'amount' => 500000,
            'distribution_date' => now()->toDateString(),
            'distributed_by' => $admin->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Transparansi Real-Time');
        $response->assertSee('Paket Sembako Fakir');
        $response->assertSee('Fakir');
    }
}
