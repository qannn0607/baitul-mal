<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use App\Services\AuditService;
use App\Services\ZakatFundService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditDistribution extends EditRecord
{
    protected static string $resource = DistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $amount = (float) ($this->data['amount'] ?? 0);
        $availableBalance = ZakatFundService::getCurrentBalance($this->record->id);

        if ($amount > $availableBalance) {
            Notification::make()
                ->danger()
                ->title('⚠️ Saldo Zakat Tidak Mencukupi!')
                ->body('Gagal memperbarui penyaluran zakat. Nominal yang Anda masukkan (Rp ' . number_format($amount, 0, ',', '.') . ') melebihi sisa saldo kas terhimpun yang tersedia (Rp ' . number_format($availableBalance, 0, ',', '.') . ').')
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    protected function afterSave(): void
    {
        AuditService::log(
            'Pembaruan Penyaluran Zakat',
            'Memperbarui data penyaluran zakat #' . $this->record->id . ' (' . $this->record->program_name . ')',
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}
