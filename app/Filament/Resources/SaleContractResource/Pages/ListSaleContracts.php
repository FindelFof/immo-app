<?php

namespace App\Filament\Resources\SaleContractResource\Pages;

use App\Filament\Resources\SaleContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaleContracts extends ListRecords
{
    protected static string $resource = SaleContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
