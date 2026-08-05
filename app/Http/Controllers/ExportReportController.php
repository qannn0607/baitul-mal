<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\ZakatLedger;
use App\Services\ZakatFundService;
use Illuminate\Http\Request;

class ExportReportController extends Controller
{
    public function financialReport(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $setting = Setting::first();

        // 1. Ledger Transactions within date range
        $ledgers = ZakatLedger::whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59',
        ])->orderBy('created_at', 'asc')->get();

        // 2. Summary stats
        $totalCollected = Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');

        $totalDistributed = Distribution::whereBetween('distribution_date', [$startDate, $endDate])
            ->sum('amount');

        $currentBalance = ZakatFundService::getCurrentBalance();

        // 3. Breakdown per 8 Asnaf within date range
        $asnafCategories = ['Fakir', 'Miskin', 'Amil', 'Muallaf', 'Riqab', 'Gharim', 'Fisabilillah', 'Ibnu Sabil'];
        $asnafBreakdown = [];

        foreach ($asnafCategories as $asnaf) {
            $sum = Distribution::where('asnaf', $asnaf)
                ->whereBetween('distribution_date', [$startDate, $endDate])
                ->sum('amount');

            $count = Distribution::where('asnaf', $asnaf)
                ->whereBetween('distribution_date', [$startDate, $endDate])
                ->count();

            $asnafBreakdown[$asnaf] = [
                'amount' => $sum,
                'count' => $count,
            ];
        }

        // 4. Distributions list
        $distributions = Distribution::whereBetween('distribution_date', [$startDate, $endDate])
            ->orderBy('distribution_date', 'desc')
            ->get();

        return view('reports.financial-report', compact(
            'startDate',
            'endDate',
            'setting',
            'ledgers',
            'totalCollected',
            'totalDistributed',
            'currentBalance',
            'asnafBreakdown',
            'distributions'
        ));
    }
}
