<?php

namespace App\Services;

use App\Models\Payment;
use App\Services\AuditService;
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

    public static function syncPaymentStatus(Payment $payment): bool
    {
        self::initConfig();

        if (empty(Config::$serverKey) || empty($payment->midtrans_order_id)) {
            return false;
        }

        try {
            $midtransStatus = \Midtrans\Transaction::status($payment->midtrans_order_id);
            $trxStatus = is_object($midtransStatus) 
                ? ($midtransStatus->transaction_status ?? null) 
                : ($midtransStatus['transaction_status'] ?? null);

            if (in_array($trxStatus, ['capture', 'settlement'])) {
                $oldValues = $payment->toArray();
                $payment->update([
                    'status' => 'Transaksi Sukses',
                    'verified_at' => now(),
                ]);

                AuditService::log(
                    'Verifikasi Pembayaran Otomatis (Midtrans Sync)',
                    'Pembayaran #' . $payment->id . ' sebesar Rp ' . number_format($payment->amount, 0, ',', '.') . ' berhasil disinkronisasi dari Midtrans Gateway.',
                    $payment,
                    $oldValues,
                    $payment->toArray()
                );

                return true;
            } elseif (in_array($trxStatus, ['cancel', 'deny', 'expire'])) {
                $oldValues = $payment->toArray();
                $payment->update([
                    'status' => 'Ditolak',
                    'rejection_reason' => 'Transaksi Midtrans ' . $trxStatus . ' (Gagal / Kadaluarsa).',
                ]);

                AuditService::log(
                    'Penolakan Pembayaran Otomatis (Midtrans Sync)',
                    'Transaksi Midtrans #' . $payment->id . ' mengalami status ' . $trxStatus . '.',
                    $payment,
                    $oldValues,
                    $payment->toArray()
                );

                return true;
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return false;
    }
}
