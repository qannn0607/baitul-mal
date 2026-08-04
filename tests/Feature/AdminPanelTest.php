<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Setting::create([
            'qris_image' => 'qris/sample.png',
            'nisab_gold_price' => 1400000,
            'zakat_fitrah_nominal' => 45000,
            'announcement_banner' => 'Banner Test',
            'org_name' => 'Baitul Maal Amil Zakat',
        ]);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/settings');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings_edit_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $setting = Setting::first();

        $response = $this->actingAs($admin)->get("/admin/settings/{$setting->id}/edit");

        $response->assertStatus(200);
    }

    public function test_admin_can_access_payments_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/payments');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_users_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_audit_logs_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/audit-logs');

        $response->assertStatus(200);
    }

    public function test_filament_logout_redirects_to_landing_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/logout');

        $response->assertRedirect('/');
    }
}
