<?php

namespace Tests\Feature;

use App\Models\MustahikApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MustahikApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_mustahik_apply_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/mustahik/apply');

        $response->assertStatus(200);
        $response->assertSee('Permohonan Bantuan Zakat (Mustahik)');
    }

    public function test_user_can_submit_mustahik_application_with_sktm_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'user']);

        $file = UploadedFile::fake()->image('sktm_proof.jpg');

        $response = $this->actingAs($user)->post('/mustahik/apply', [
            'applicant_name' => 'Bapak Supardi',
            'nik' => '3171012345670001',
            'phone' => '081234567890',
            'address' => 'Jl. Kebajikan No. 12, Jakarta',
            'asnaf_category' => 'Miskin',
            'program_type' => 'Bantuan Pengobatan & Kesehatan Darurat',
            'amount_requested' => 500000,
            'reason' => 'Permohonan bantuan biaya pengobatan rawat inap puskesmas.',
            'sktm_proof_image' => $file,
        ]);

        $response->assertRedirect('/mustahik/my-applications');

        $this->assertDatabaseHas('mustahik_applications', [
            'applicant_name' => 'Bapak Supardi',
            'nik' => '3171012345670001',
            'asnaf_category' => 'Miskin',
            'amount_requested' => 500000,
            'status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_admin_can_access_mustahik_applications_resource_in_filament(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/mustahik-applications');

        $response->assertStatus(200);
    }
}
