<?php

namespace App\Filament\Resources\MustahikApplicationResource\Pages;

use App\Filament\Resources\MustahikApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMustahikApplications extends ListRecords
{
    protected static string $resource = MustahikApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
