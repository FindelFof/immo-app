<?php

namespace App\Filament\Resources\RentPaymentResource\Pages;

use App\Filament\Resources\RentPaymentResource;
use App\Filament\Widgets\RentPaymentStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListRentPayments extends ListRecords
{
    protected static string $resource = RentPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make()
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            RentPaymentStats::class
        ];
    }
}
