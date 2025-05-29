<?php

namespace App\Filament\Resources\RentalContractResource\Pages;

use App\Filament\Resources\RentalContractResource;
use App\Filament\Widgets\RentalContractStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalContracts extends ListRecords
{
    protected static string $resource = RentalContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            RentalContractStats::class
        ];
    }
}
