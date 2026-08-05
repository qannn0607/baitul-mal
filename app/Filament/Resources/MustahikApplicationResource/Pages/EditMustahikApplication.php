<?php

namespace App\Filament\Resources\MustahikApplicationResource\Pages;

use App\Filament\Resources\MustahikApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMustahikApplication extends EditRecord
{
    protected static string $resource = MustahikApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
