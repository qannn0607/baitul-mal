<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class ZakatTypeChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Kategori Zakat & Infaq';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $types = ['Zakat Maal', 'Zakat Penghasilan', 'Zakat Fitrah', 'Infaq / Sedekah'];
        $counts = [];

        foreach ($types as $type) {
            $counts[] = Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])
                ->where('title', 'like', '%' . $type . '%')
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Nominal (Rp)',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#10b981', // Emerald
                        '#14b8a6', // Teal
                        '#f59e0b', // Amber
                        '#0284c7', // Sky
                    ],
                ],
            ],
            'labels' => $types,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
