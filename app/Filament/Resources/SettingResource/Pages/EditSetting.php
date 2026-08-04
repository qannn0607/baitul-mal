<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Services\AuditService;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function afterSave(): void
    {
        AuditService::log(
            'Update Pengaturan',
            'Memperbarui pengaturan sistem dan nisab zakat.',
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}
