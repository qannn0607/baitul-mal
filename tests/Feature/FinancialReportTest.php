<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_financial_report_print_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/reports/financial/print');

        $response->assertStatus(200);
        $response->assertSee('LAPORAN MUTASI KAS & PENYALURAN ZAKAT', false);
    }
}
