<?php

namespace App\Filament\Resources\ZakatLedgerResource\Pages;

use App\Filament\Resources\ZakatLedgerResource;
use Filament\Resources\Pages\ListRecords;

class ListZakatLedgers extends ListRecords
{
    protected static string $resource = ZakatLedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
