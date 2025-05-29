<?php

namespace App\Filament\Resources\PropertyVisitResource\Pages;

use App\Filament\Resources\PropertyVisitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyVisits extends ListRecords
{
    protected static string $resource = PropertyVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
