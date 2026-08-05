<?php

namespace App\Services;

use App\Models\Distribution;
use App\Models\Payment;
use App\Models\ZakatBalance;
use App\Models\ZakatLedger;
use Illuminate\Support\Facades\DB;

class ZakatFundService
{
    /**
     * Dapatkan sisa saldo kas zakat saat ini
     */
    public static function getCurrentBalance(?int $excludeDistributionId = null): float
    {
        $totalCollected = Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');

        $query = Distribution::query();
        if ($excludeDistributionId) {
            $query->where('id', '!=', $excludeDistributionId);
        }
        $totalDistributed = $query->sum('amount');

        return max(0, (float) ($totalCollected - $totalDistributed));
    }

    /**
     * Hitung ulang seluruh saldo & sinkronkan Buku Kas Zakat (Ledger)
     */
    public static function recalculateBalance(): ZakatBalance
    {
        return DB::transaction(function () {
            $totalCollected = (float) Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');
            $totalDistributed = (float) Distribution::sum('amount');
            $currentBalance = max(0, $totalCollected - $totalDistributed);

            $balanceRecord = ZakatBalance::getInstance();
            $balanceRecord->update([
                'total_collected' => $totalCollected,
                'total_distributed' => $totalDistributed,
                'current_balance' => $currentBalance,
            ]);

            return $balanceRecord;
        });
    }

    /**
     * Catat Uang Masuk (Credit) saat Pembayaran Zakat Sukses
     */
    public static function recordPaymentCredit(Payment $payment): void
    {
        if (! in_array($payment->status, ['Transaksi Sukses', 'Sudah Disalurkan'])) {
            return;
        }

        DB::transaction(function () use ($payment) {
            // Cek apakah sudah dicatat sebelumnya
            $existing = ZakatLedger::where('payment_id', $payment->id)->first();
            if ($existing) {
                static::recalculateBalance();
                return;
            }

            $balanceAfter = static::getCurrentBalance();

            ZakatLedger::create([
                'payment_id' => $payment->id,
                'type' => 'credit',
                'amount' => $payment->amount,
                'balance_after' => $balanceAfter,
                'description' => "Penerimaan Zakat ({$payment->title}) - #TRX-" . str_pad($payment->id, 5, '0', STR_PAD_LEFT) . " dari {$payment->sender_name}",
            ]);

            static::recalculateBalance();
        });
    }

    /**
     * Hapus / Batalkan Uang Masuk (Misal Status Berubah)
     */
    public static function removePaymentCredit(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            ZakatLedger::where('payment_id', $payment->id)->delete();
            static::recalculateBalance();
        });
    }

    /**
     * Catat Uang Keluar (Debit) saat Admin Menyalurkan Zakat
     */
    public static function recordDistributionDebit(Distribution $distribution): void
    {
        DB::transaction(function () use ($distribution) {
            $available = static::getCurrentBalance($distribution->id);

            if ($distribution->amount > $available) {
                throw new \InvalidArgumentException("Nominal penyaluran (Rp " . number_format($distribution->amount, 0, ',', '.') . ") melebihi saldo kas zakat yang tersedia (Rp " . number_format($available, 0, ',', '.') . "). Saldo tidak mencukupi!");
            }

            // Hapus ledger lama jika edit
            ZakatLedger::where('distribution_id', $distribution->id)->delete();

            $balanceAfter = static::getCurrentBalance();

            ZakatLedger::create([
                'distribution_id' => $distribution->id,
                'type' => 'debit',
                'amount' => $distribution->amount,
                'balance_after' => $balanceAfter,
                'description' => "Penyaluran Zakat [{$distribution->asnaf}] - {$distribution->program_name} kepada {$distribution->recipient_name}",
            ]);

            static::recalculateBalance();
        });
    }

    /**
     * Hapus Penyaluran (Debit)
     */
    public static function removeDistributionDebit(Distribution $distribution): void
    {
        DB::transaction(function () use ($distribution) {
            ZakatLedger::where('distribution_id', $distribution->id)->delete();
            static::recalculateBalance();
        });
    }
}
