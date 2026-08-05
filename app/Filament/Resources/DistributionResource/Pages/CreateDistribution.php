<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use App\Services\AuditService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDistribution extends CreateRecord
{
    protected static string $resource = DistributionResource::class;

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
