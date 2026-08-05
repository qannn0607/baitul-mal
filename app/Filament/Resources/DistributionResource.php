<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistributionResource\Pages;
use App\Models\Distribution;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DistributionResource extends Resource
{
    protected static ?string $model = Distribution::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';

    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Zakat & Penyaluran';

    protected static ?string $navigationLabel = 'Penyaluran Zakat (8 Asnaf)';

    protected static ?string $modelLabel = 'Penyaluran Zakat';

    protected static ?string $pluralModelLabel = 'Penyaluran Zakat';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('program_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Bantuan Sembako Dhuafa / Beasiswa Santri')
                    ->label('Nama Program Penyaluran'),

                Forms\Components\Select::make('asnaf')
                    ->options([
                        'Fakir' => '🔴 Fakir (Sangat miskin / tidak berpenghasilan)',
                        'Miskin' => '🟡 Miskin (Penghasilan tidak mencukupi)',
                        'Amil' => '🔵 Amil (Pengelola zakat)',
                        'Muallaf' => '🟢 Muallaf (Baru masuk Islam)',
                        'Riqab' => '🟣 Riqab (Hamba sahaya / pembebasan)',
                        'Gharim' => '🟠 Gharim (Terlilit hutang kebutuhan pokok)',
                        'Fisabilillah' => '❇️ Fisabilillah (Pejuang agama / dakwah)',
                        'Ibnu Sabil' => '🌐 Ibnu Sabil (Musafir kehabisan bekal)',
                    ])
                    ->required()
                    ->label('Kategori 8 Asnaf'),

                Forms\Components\TextInput::make('recipient_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Nama individu, keluarga, atau lembaga penerima')
                    ->label('Penerima Manfaat (Mustahik)'),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(1000)
                    ->placeholder('Contoh: 1500000')
                    ->label('Nominal Penyaluran (Rp)'),

                Forms\Components\DatePicker::make('distribution_date')
                    ->required()
                    ->default(now())
                    ->label('Tanggal Penyaluran'),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->placeholder('Keterangan pelaksanaan penyaluran atau rincian bantuan...')
                    ->label('Catatan / Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('distribution_date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('program_name')
                    ->searchable()
                    ->weight('bold')
                    ->label('Nama Program'),

                Tables\Columns\TextColumn::make('asnaf')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fakir' => 'danger',
                        'Miskin' => 'warning',
                        'Amil' => 'info',
                        'Muallaf' => 'success',
                        'Riqab' => 'purple',
                        'Gharim' => 'rose',
                        'Fisabilillah' => 'emerald',
                        'Ibnu Sabil' => 'indigo',
                        default => 'gray',
                    })
                    ->label('8 Asnaf'),

                Tables\Columns\TextColumn::make('recipient_name')
                    ->searchable()
                    ->label('Penerima Manfaat'),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->label('Nominal'),

                Tables\Columns\TextColumn::make('amil.name')
                    ->default('System Admin')
                    ->label('Petugas Amil'),
            ])
            ->defaultSort('distribution_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('asnaf')
                    ->options([
                        'Fakir' => 'Fakir',
                        'Miskin' => 'Miskin',
                        'Amil' => 'Amil',
                        'Muallaf' => 'Muallaf',
                        'Riqab' => 'Riqab',
                        'Gharim' => 'Gharim',
                        'Fisabilillah' => 'Fisabilillah',
                        'Ibnu Sabil' => 'Ibnu Sabil',
                    ])
                    ->label('Filter Asnaf'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDistributions::route('/'),
            'create' => Pages\CreateDistribution::route('/create'),
            'edit' => Pages\EditDistribution::route('/{record}/edit'),
        ];
    }
}
