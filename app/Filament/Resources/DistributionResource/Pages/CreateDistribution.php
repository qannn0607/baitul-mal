<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use App\Services\AuditService;
use App\Services\ZakatFundService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDistribution extends CreateRecord
{
    protected static string $resource = DistributionResource::class;

    protected function beforeCreate(): void
    {
        $amount = (float) ($this->data['amount'] ?? 0);
        $availableBalance = ZakatFundService::getCurrentBalance();

        if ($amount > $availableBalance) {
            Notification::make()
                ->danger()
                ->title('⚠️ Saldo Zakat Tidak Mencukupi!')
                ->body('Gagal mencatat penyaluran zakat. Nominal yang Anda masukkan (Rp ' . number_format($amount, 0, ',', '.') . ') melebihi sisa saldo kas terhimpun yang tersedia (Rp ' . number_format($availableBalance, 0, ',', '.') . ').')
                ->persistent()
                ->send();

            $this->halt();
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['distributed_by'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        AuditService::log(
            'Pencatatan Penyaluran Zakat',
            'Menambahkan penyaluran zakat Asnaf ' . $this->record->asnaf . ' kepada ' . $this->record->recipient_name . ' sebesar Rp ' . number_format($this->record->amount, 0, ',', '.'),
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}
