<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use App\Services\AuditService;
use Filament\Actions;
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
