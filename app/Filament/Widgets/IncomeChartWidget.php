<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class IncomeChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penghimpunan Zakat (6 Bulan Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect();
        $amounts = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->translatedFormat('M Y'));

            $total = Payment::whereIn('status', ['Diverifikasi', 'Sudah Disalurkan'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');

            $amounts->push($total);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Zakat (Rp)',
                    'data' => $amounts->toArray(),
                    'borderColor' => '#059669',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
