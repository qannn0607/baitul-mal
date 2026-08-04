<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Services\AuditService;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan QRIS & Sistem';

    protected static ?string $pluralModelLabel = 'Pengaturan Sistem';

    protected static ?string $modelLabel = 'Pengaturan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Banner & Nisab')
                    ->schema([
                        Forms\Components\Textarea::make('announcement_banner')
                            ->label('Pengumuman Banner (Ditampilkan di Dashboard Muzakki)')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('nisab_gold_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Harga Emas per Gram (Acuan Nisab)'),

                        Forms\Components\TextInput::make('zakat_fitrah_nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Nominal Zakat Fitrah per Jiwa'),

                        Forms\Components\FileUpload::make('qris_image')
                            ->image()
                            ->directory('qris')
                            ->disk('public')
                            ->label('Upload Gambar QRIS Resmi'),
                    ])->columns(2),

                Forms\Components\Section::make('Rekening Bank Transfer Resmi')
                    ->schema([
                        Forms\Components\Repeater::make('bank_accounts')
                            ->schema([
                                Forms\Components\TextInput::make('bank_name')
                                    ->label('Nama Bank / E-Wallet')
                                    ->required(),
                                Forms\Components\TextInput::make('account_number')
                                    ->label('Nomor Rekening / HP')
                                    ->required(),
                                Forms\Components\TextInput::make('account_name')
                                    ->label('Atas Nama (a.n)')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->defaultItems(2),
                    ]),

                Forms\Components\Section::make('Informasi Organisasi & Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('org_name')
                            ->label('Nama Organisasi')
                            ->default('Baitul Maal Amil Zakat'),
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Telepon Kontak'),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email Kontak'),
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Alamat Kantor')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('qris_image')
                    ->disk('public')
                    ->label('Gambar QRIS'),

                Tables\Columns\TextColumn::make('nisab_gold_price')
                    ->money('IDR')
                    ->label('Harga Emas / Gram'),

                Tables\Columns\TextColumn::make('zakat_fitrah_nominal')
                    ->money('IDR')
                    ->label('Nominal Zakat Fitrah / Jiwa'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->label('Terakhir Diperbarui'),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
