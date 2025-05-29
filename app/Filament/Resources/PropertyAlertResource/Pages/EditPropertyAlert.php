<?php

namespace App\Filament\Resources\PropertyAlertResource\Pages;

use App\Filament\Resources\PropertyAlertResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyAlert extends EditRecord
{
    protected static string $resource = PropertyAlertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
