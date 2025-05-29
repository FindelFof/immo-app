<?php

namespace App\Filament\Resources\PropertyAlertResource\Pages;

use App\Filament\Resources\PropertyAlertResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyAlerts extends ListRecords
{
    protected static string $resource = PropertyAlertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
