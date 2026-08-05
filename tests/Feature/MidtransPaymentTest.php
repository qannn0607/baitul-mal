<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_payment_and_receive_snap_token(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/bayar-zakat', [
            'sender_name' => 'Ahmad Hidayat',
            'title' => 'Zakat Maal',
            'amount' => 500000,
            'payment_method' => 'midtrans',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'sender_name' => 'Ahmad Hidayat',
            'amount' => 500000,
            'status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_midtrans_webhook_callback_automatically_verifies_payment(): void
    {
        $user = User::factory()->create();
        $payment = Payment::create([
            'user_id' => $user->id,
            'sender_name' => 'Budi Santoso',
            'title' => 'Zakat Fitrah',
            'amount' => 45000,
            'midtrans_order_id' => 'TRX-' . time() . '-999',
            'status' => 'Menunggu Verifikasi',
        ]);

        $serverKey = config('services.midtrans.server_key');
        $orderId = $payment->midtrans_order_id;
        $statusCode = '200';
        $grossAmount = '45000';
        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'payment_id' => $payment->id,
            'payment_status' => 'Transaksi Sukses',
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'Transaksi Sukses',
        ]);
    }

    public function test_user_can_manually_trigger_payment_status_check(): void
    {
        $user = User::factory()->create();
        $payment = Payment::create([
            'user_id' => $user->id,
            'sender_name' => 'Budi Santoso',
            'title' => 'Zakat Fitrah',
            'amount' => 45000,
            'midtrans_order_id' => 'TRX-TEST-123',
            'status' => 'Menunggu Verifikasi',
        ]);

        $response = $this->actingAs($user)->get(route('zakat.check', $payment));

        $response->assertRedirect(route('zakat.history'));
    }
}
