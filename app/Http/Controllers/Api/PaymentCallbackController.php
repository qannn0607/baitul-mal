<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\AuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function handleNotification(Request $request): JsonResponse
    {
        $serverKey = config('services.midtrans.server_key');

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $transactionStatus = $request->input('transaction_status');

        // Verify Midtrans Signature Key if serverKey exists
        if ($serverKey && $signatureKey) {
            $computedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            if ($computedSignature !== $signatureKey) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        // Find payment by midtrans_order_id or parse ID from TRX-{id}-{time}
        $payment = Payment::where('midtrans_order_id', $orderId)->first();

        if (! $payment && $orderId) {
            $parts = explode('-', $orderId);
            if (isset($parts[1]) && is_numeric($parts[1])) {
                $payment = Payment::find((int) $parts[1]);
            }
        }

        if (! $payment) {
            return response()->json(['message' => 'Payment record not found'], 444);
        }

        $oldValues = $payment->toArray();

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $payment->update([
                'status' => 'Diverifikasi',
                'verified_at' => now(),
            ]);

            AuditService::log(
                'Verifikasi Pembayaran Otomatis',
                'Pembayaran #' . $payment->id . ' sebesar Rp ' . number_format($payment->amount, 0, ',', '.') . ' berhasil diverifikasi otomatis via Midtrans Gateway.',
                $payment,
                $oldValues,
                $payment->toArray()
            );
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->update([
                'status' => 'Ditolak',
                'rejection_reason' => 'Transaksi Midtrans ' . $transactionStatus . ' (Gagal / Kadaluarsa).',
            ]);

            AuditService::log(
                'Penolakan Pembayaran Otomatis',
                'Transaksi Midtrans #' . $payment->id . ' mengalami status ' . $transactionStatus . '.',
                $payment,
                $oldValues,
                $payment->toArray()
            );
        }

        return response()->json([
            'status' => 'success',
            'payment_id' => $payment->id,
            'payment_status' => $payment->status,
        ]);
    }
}
