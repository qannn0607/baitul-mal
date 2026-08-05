<?php

namespace App\Services;

use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public static function initConfig(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('services.midtrans.is_3ds', true);
    }

    public static function createSnapToken(Payment $payment): ?string
    {
        self::initConfig();

        if (empty(Config::$serverKey)) {
            return null;
        }

        $orderId = $payment->midtrans_order_id ?? ('TRX-' . $payment->id . '-' . time());

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $payment->sender_name,
                'email' => $payment->user->email ?? 'muzakki@baitulmaal.org',
                'phone' => $payment->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'ZAKAT-' . $payment->id,
                    'price' => (int) $payment->amount,
                    'quantity' => 1,
                    'name' => $payment->title,
                ],
            ],
            'callbacks' => [
                'finish' => route('zakat.history'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $payment->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $orderId,
            ]);

            return $snapToken;
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }
}
