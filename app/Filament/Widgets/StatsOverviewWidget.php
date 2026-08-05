<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalVerifiedAmount = Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');
        $pendingCount = Payment::where('status', 'Menunggu Verifikasi')->count();
        $distributedCount = Payment::where('status', 'Sudah Disalurkan')->count();
        $totalMuzakki = User::where('role', 'user')->count();

        return [
            Stat::make('Total Zakat Terkumpul', 'Rp ' . number_format($totalVerifiedAmount, 0, ',', '.'))
                ->description('Dari transaksi sukses & disalurkan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Menunggu Verifikasi', $pendingCount . ' Transaksi')
                ->description('Perlu tindakan verifikasi admin')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Sudah Disalurkan', $distributedCount . ' Transaksi')
                ->description('Zakat yang telah sampai ke Mustahik')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make('Total Muzakki', $totalMuzakki . ' Orang')
                ->description('Muzakki terdaftar dalam sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
