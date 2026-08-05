<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Services\AuditService;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentPaymentsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Transaksi Pembayaran Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(Payment::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('sender_name')
                    ->weight('bold')
                    ->label('Nama Pengirim'),

                Tables\Columns\TextColumn::make('title')
                    ->badge()
                    ->color('gray')
                    ->label('Peruntukan'),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->label('Nominal'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'warning',
                        'Transaksi Sukses' => 'success',
                        'Sudah Disalurkan' => 'info',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status'),
            ])
            ->actions([
                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Payment $record): bool => $record->status === 'Menunggu Verifikasi')
                    ->action(function (Payment $record) {
                        $oldValues = $record->toArray();
                        $record->update([
                            'status' => 'Transaksi Sukses',
                            'verified_by' => Auth::id(),
                            'verified_at' => now(),
                        ]);

                        AuditService::log(
                            'Verifikasi Pembayaran',
                            'Memverifikasi pembayaran #' . $record->id . ' sebesar Rp ' . number_format($record->amount, 0, ',', '.'),
                            $record,
                            $oldValues,
                            $record->toArray()
                        );
                    }),

                Action::make('distribute')
                    ->label('Disalurkan')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (Payment $record): bool => in_array($record->status, ['Transaksi Sukses', 'Menunggu Verifikasi']))
                    ->action(function (Payment $record) {
                        $oldValues = $record->toArray();
                        $record->update([
                            'status' => 'Sudah Disalurkan',
                            'distributed_at' => now(),
                        ]);

                        AuditService::log(
                            'Penyaluran Zakat',
                            'Zakat #' . $record->id . ' telah disalurkan kepada Mustahik.',
                            $record,
                            $oldValues,
                            $record->toArray()
                        );
                    }),
            ]);
    }
}
