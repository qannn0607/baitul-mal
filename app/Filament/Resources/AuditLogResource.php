<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static \UnitEnum|string|null $navigationGroup = 'Sistem & Keamanan';

    protected static ?string $navigationLabel = 'Audit Logs Aktivitas';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('user.name')
                    ->label('Pengguna')
                    ->disabled(),
                Forms\Components\TextInput::make('action')
                    ->label('Aksi / Tindakan')
                    ->disabled(),
                Forms\Components\TextInput::make('model_type')
                    ->label('Entitas Target')
                    ->disabled(),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\KeyValue::make('old_values')
                    ->label('Nilai Sebelum')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\KeyValue::make('new_values')
                    ->label('Nilai Sesudah')
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna / Amil')
                    ->searchable()
                    ->default('Sistem'),

                Tables\Columns\TextColumn::make('action')
                    ->label('Tindakan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Verifikasi Pembayaran' => 'success',
                        'Penolakan Pembayaran' => 'danger',
                        'Penyaluran Zakat' => 'info',
                        'Update Pengaturan' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'Verifikasi Pembayaran' => 'Verifikasi Pembayaran',
                        'Penolakan Pembayaran' => 'Penolakan Pembayaran',
                        'Penyaluran Zakat' => 'Penyaluran Zakat',
                        'Update Pengaturan' => 'Update Pengaturan',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}
