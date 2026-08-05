<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MustahikApplicationResource\Pages;
use App\Models\Distribution;
use App\Models\MustahikApplication;
use App\Services\AuditService;
use App\Services\ZakatFundService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MustahikApplicationResource extends Resource
{
    protected static ?string $model = MustahikApplication::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Zakat & Penyaluran';

    protected static ?string $navigationLabel = 'Kelola Permohonan Mustahik';

    protected static ?string $modelLabel = 'Permohonan Mustahik';

    protected static ?string $pluralModelLabel = 'Permohonan Bantuan Mustahik';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('applicant_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pemohon'),

                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->length(16)
                    ->label('NIK KTP (16 Digit)'),

                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->label('Nomor Telepon / WA'),

                Forms\Components\Select::make('asnaf_category')
                    ->options([
                        'Fakir' => '🔴 Fakir (Sangat Miskin / Tidak Berpenghasilan)',
                        'Miskin' => '🟡 Miskin (Penghasilan Kurang)',
                        'Gharim' => '🟠 Gharim (Terlilit Hutang Pokok)',
                        'Fisabilillah' => '❇️ Fisabilillah (Pejuang Agama / Dakwah)',
                        'Ibnu Sabil' => '🌐 Ibnu Sabil (Musafir Kehabisan Bekal)',
                        'Muallaf' => '🟢 Muallaf (Baru Masuk Islam)',
                        'Amil' => '🔵 Amil (Pengelola Zakat)',
                    ])
                    ->required()
                    ->label('Kategori 8 Asnaf'),

                Forms\Components\TextInput::make('program_type')
                    ->required()
                    ->label('Jenis Program Bantuan'),

                Forms\Components\TextInput::make('amount_requested')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Nominal Pengajuan (Rp)'),

                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => '🟡 Menunggu Verifikasi',
                        'Disetujui' => '🟢 Disetujui Amil',
                        'Telah Disalurkan' => '🔵 Telah Disalurkan',
                        'Ditolak' => '🔴 Ditolak',
                    ])
                    ->required()
                    ->label('Status Permohonan'),

                Forms\Components\FileUpload::make('sktm_proof_image')
                    ->image()
                    ->directory('sktm_proofs')
                    ->disk('public')
                    ->label('Berkas KTP / SKTM'),

                Forms\Components\Textarea::make('address')
                    ->columnSpanFull()
                    ->label('Alamat Domisili'),

                Forms\Components\Textarea::make('reason')
                    ->columnSpanFull()
                    ->label('Alasan / Rincian Permohonan'),

                Forms\Components\Textarea::make('rejection_reason')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('status') === 'Ditolak')
                    ->label('Alasan Penolakan'),
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

                Tables\Columns\TextColumn::make('applicant_name')
                    ->searchable()
                    ->weight('bold')
                    ->label('Nama Pemohon'),

                Tables\Columns\TextColumn::make('asnaf_category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fakir' => 'danger',
                        'Miskin' => 'warning',
                        'Amil' => 'info',
                        'Muallaf' => 'success',
                        'Gharim' => 'rose',
                        'Fisabilillah' => 'emerald',
                        'Ibnu Sabil' => 'indigo',
                        default => 'gray',
                    })
                    ->label('Asnaf'),

                Tables\Columns\TextColumn::make('program_type')
                    ->searchable()
                    ->label('Program Bantuan'),

                Tables\Columns\TextColumn::make('amount_requested')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->label('Nominal Pengajuan'),

                Tables\Columns\ImageColumn::make('sktm_proof_image')
                    ->disk('public')
                    ->url(fn ($record) => $record->sktm_proof_image ? asset('storage/' . $record->sktm_proof_image) : null)
                    ->openUrlInNewTab()
                    ->label('Berkas SKTM/KTP'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'warning',
                        'Disetujui' => 'success',
                        'Telah Disalurkan' => 'info',
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
                        'Disetujui' => 'Disetujui',
                        'Telah Disalurkan' => 'Telah Disalurkan',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->label('Filter Status'),
            ])
            ->actions([
                // Action Setujui (Approve)
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (MustahikApplication $record): bool => $record->status === 'Menunggu Verifikasi')
                    ->action(function (MustahikApplication $record) {
                        $oldValues = $record->toArray();
                        $record->update([
                            'status' => 'Disetujui',
                            'verified_by' => Auth::id(),
                            'verified_at' => now(),
                        ]);

                        AuditService::log(
                            'Persetujuan Permohonan Mustahik',
                            'Menyetujui permohonan bantuan zakat #' . $record->id . ' atas nama ' . $record->applicant_name,
                            $record,
                            $oldValues,
                            $record->toArray()
                        );

                        Notification::make()
                            ->success()
                            ->title('Permohonan Disetujui')
                            ->body('Permohonan bantuan atas nama ' . $record->applicant_name . ' telah disetujui.')
                            ->send();
                    }),

                // Action Tolak (Reject)
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (MustahikApplication $record): bool => $record->status === 'Menunggu Verifikasi')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Contoh: Berkas SKTM tidak melampirkan keterangan rt/rw atau data NIK tidak terdaftar.'),
                    ])
                    ->action(function (MustahikApplication $record, array $data) {
                        $oldValues = $record->toArray();
                        $record->update([
                            'status' => 'Ditolak',
                            'rejection_reason' => $data['rejection_reason'],
                            'verified_by' => Auth::id(),
                            'verified_at' => now(),
                        ]);

                        AuditService::log(
                            'Penolakan Permohonan Mustahik',
                            'Menolak permohonan bantuan zakat #' . $record->id . '. Alasan: ' . $data['rejection_reason'],
                            $record,
                            $oldValues,
                            $record->toArray()
                        );

                        Notification::make()
                            ->warning()
                            ->title('Permohonan Ditolak')
                            ->body('Permohonan telah ditolak dengan alasan: ' . $data['rejection_reason'])
                            ->send();
                    }),

                // Action Process Distribution (Salurkan Zakat)
                Action::make('process_distribution')
                    ->label('Salurkan Zakat')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->visible(fn (MustahikApplication $record): bool => in_array($record->status, ['Disetujui', 'Menunggu Verifikasi']))
                    ->form([
                        Forms\Components\TextInput::make('program_name')
                            ->default(fn (MustahikApplication $record) => $record->program_type)
                            ->required()
                            ->label('Nama Program Penyaluran'),

                        Forms\Components\Select::make('asnaf')
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
                            ->default(fn (MustahikApplication $record) => $record->asnaf_category)
                            ->required()
                            ->label('Kategori 8 Asnaf'),

                        Forms\Components\TextInput::make('recipient_name')
                            ->default(fn (MustahikApplication $record) => $record->applicant_name)
                            ->required()
                            ->label('Nama Penerima Manfaat'),

                        Forms\Components\TextInput::make('amount')
                            ->default(fn (MustahikApplication $record) => $record->amount_requested)
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Nominal Penyaluran (Rp)'),
                    ])
                    ->action(function (MustahikApplication $record, array $data) {
                        $available = ZakatFundService::getCurrentBalance();
                        if ((float) $data['amount'] > $available) {
                            Notification::make()
                                ->danger()
                                ->title('⚠️ Saldo Zakat Tidak Mencukupi!')
                                ->body('Gagal menyalurkan zakat. Nominal (Rp ' . number_format($data['amount'], 0, ',', '.') . ') melebihi saldo kas terhimpun yang tersedia (Rp ' . number_format($available, 0, ',', '.') . ').')
                                ->persistent()
                                ->send();

                            return;
                        }

                        // Create Distribution
                        $distribution = Distribution::create([
                            'program_name' => $data['program_name'],
                            'asnaf' => $data['asnaf'],
                            'recipient_name' => $data['recipient_name'],
                            'amount' => $data['amount'],
                            'distribution_date' => now()->toDateString(),
                            'notes' => 'Penyaluran zakat dari Permohonan Mustahik #' . $record->id . ' NIK: ' . $record->nik,
                            'distributed_by' => Auth::id(),
                        ]);

                        // Update Mustahik Application status
                        $record->update([
                            'status' => 'Telah Disalurkan',
                            'verified_by' => Auth::id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Penyaluran Zakat Berhasil')
                            ->body('Penyaluran zakat sebesar Rp ' . number_format($data['amount'], 0, ',', '.') . ' telah diproses dan dicatat di Buku Kas Zakat.')
                            ->send();
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
            'index' => Pages\ListMustahikApplications::route('/'),
            'create' => Pages\CreateMustahikApplication::route('/create'),
            'edit' => Pages\EditMustahikApplication::route('/{record}/edit'),
        ];
    }
}
