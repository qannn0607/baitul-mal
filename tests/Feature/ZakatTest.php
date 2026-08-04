<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ZakatTest extends TestCase
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
        ]);
    }

    public function test_user_can_access_zakat_calculator(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/hitung-zakat');

        $response->assertStatus(200);
        $response->assertSee('Kalkulator Zakat Digital');
    }

    public function test_user_can_access_pay_zakat_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/bayar-zakat');

        $response->assertStatus(200);
        $response->assertSee('Form Pembayaran Zakat');
    }

    public function test_user_can_submit_zakat_payment_with_proof_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('receipt.jpg', 600, 800);

        $response = $this->actingAs($user)->post('/bayar-zakat', [
            'sender_name' => $user->name,
            'title' => 'Zakat Penghasilan',
            'amount' => 250000,
            'proof_image' => $file,
        ]);

        $response->assertRedirect(route('zakat.history'));
        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'sender_name' => $user->name,
            'title' => 'Zakat Penghasilan',
            'amount' => 250000,
            'status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_user_can_view_payment_history(): void
    {
        $user = User::factory()->create();

        Payment::create([
            'user_id' => $user->id,
            'sender_name' => $user->name,
            'title' => 'Zakat Maal',
            'amount' => 500000,
            'proof_image' => 'payment_proofs/sample.png',
            'status' => 'Diverifikasi',
        ]);

        $response = $this->actingAs($user)->get('/riwayat-pembayaran');

        $response->assertStatus(200);
        $response->assertSee('Zakat Maal');
        $response->assertSee('Rp 500.000');
    }

    public function test_user_can_view_receipt_for_verified_payment(): void
    {
        $user = User::factory()->create();

        $payment = Payment::create([
            'user_id' => $user->id,
            'sender_name' => $user->name,
            'title' => 'Zakat Maal',
            'amount' => 1000000,
            'proof_image' => 'payment_proofs/sample.png',
            'status' => 'Diverifikasi',
        ]);

        $response = $this->actingAs($user)->get(route('zakat.receipt', $payment));

        $response->assertStatus(200);
        $response->assertSee('BUKTI SAH PENERIMAAN');
    }
}
