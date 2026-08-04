<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Kelola Pembayaran Zakat';

    protected static ?string $pluralModelLabel = 'Pembayaran Zakat';

    protected static ?string $modelLabel = 'Pembayaran Zakat';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->label('Muzakki / User'),

                Forms\Components\TextInput::make('sender_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pengirim'),

                Forms\Components\Select::make('title')
                    ->options([
                        'Zakat Maal' => 'Zakat Maal',
                        'Zakat Penghasilan' => 'Zakat Penghasilan',
                        'Zakat Fitrah' => 'Zakat Fitrah',
                        'Donasi / Infaq' => 'Donasi / Infaq',
                    ])
                    ->required()
                    ->label('Peruntukan Zakat'),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Nominal Pembayaran'),

                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => '🟡 Menunggu Verifikasi',
                        'Diverifikasi' => '🟢 Diverifikasi',
                        'Sudah Disalurkan' => '🔵 Sudah Disalurkan',
                        'Ditolak' => '🔴 Ditolak',
                    ])
                    ->default('Menunggu Verifikasi')
                    ->required()
                    ->label('Status Pembayaran'),

                Forms\Components\FileUpload::make('proof_image')
                    ->image()
                    ->directory('payment_proofs')
                    ->disk('public')
                    ->label('Bukti Transfer'),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Catatan Penyaluran / Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('sender_name')
                    ->searchable()
                    ->weight('bold')
                    ->label('Nama Pengirim'),

                Tables\Columns\TextColumn::make('title')
                    ->badge()
                    ->color('gray')
                    ->label('Peruntukan'),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->label('Nominal'),

                Tables\Columns\ImageColumn::make('proof_image')
                    ->disk('public')
                    ->label('Bukti Transfer'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'warning',
                        'Diverifikasi' => 'success',
                        'Sudah Disalurkan' => 'info',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Diverifikasi' => 'Diverifikasi',
                        'Sudah Disalurkan' => 'Sudah Disalurkan',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->label('Filter Status'),
            ])
            ->actions([
                // Tombol aksi Cepat Verifikasi
                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Payment $record): bool => $record->status === 'Menunggu Verifikasi')
                    ->action(function (Payment $record) {
                        $record->update([
                            'status' => 'Diverifikasi',
                            'verified_at' => now(),
                        ]);
                    }),

                // Tombol aksi Cepat "Zakat Disalurkan" (Permintaan Spesifik User)
                Action::make('distribute')
                    ->label('Zakat Disalurkan')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (Payment $record): bool => in_array($record->status, ['Diverifikasi', 'Menunggu Verifikasi']))
                    ->action(function (Payment $record) {
                        $record->update([
                            'status' => 'Sudah Disalurkan',
                            'distributed_at' => now(),
                        ]);
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
