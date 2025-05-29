<?php

namespace App\Filament\Resources\PropertyFavoriteResource\Pages;

use App\Filament\Resources\PropertyFavoriteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyFavorites extends ListRecords
{
    protected static string $resource = PropertyFavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
