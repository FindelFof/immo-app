<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\RentalContract;
use App\Models\PropertyRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PropertyStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '180s';

    protected int | string | array $columnSpan = 6;



    protected function getStats(): array
    {
        return [
            Stat::make('Propriétés à Vendre', Property::where('type', 'sale')->where('status', 'available')->count())
                ->description('Biens disponibles à la vente')
                ->descriptionIcon('heroicon-m-home')
                ->color('success')
                ->chart(self::getSalePropertyTrend()),

            Stat::make('Propriétés à Louer', Property::where('type', 'rent')->where('status', 'available')->count())
                ->description('Biens disponibles à la location')
                ->descriptionIcon('heroicon-m-key')
                ->color('warning')
                ->chart(self::getRentPropertyTrend()),

            Stat::make('Demandes en attente', PropertyRequest::where('status', 'pending')->count())
                ->description('Demandes nécessitant une action')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('danger')
                ->chart(self::getRequestsTrend()),

            Stat::make('Contrats actifs', RentalContract::where('status', 'active')->count())
                ->description('Contrats de location en cours')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('primary')
                ->chart(self::getContractsTrend()),
        ];
    }

    private static function getSalePropertyTrend(): array
    {
        // Données fictives pour l'exemple - à remplacer par des données réelles
        return [3, 5, 7, 5, 10, 8, 12, 14, 15];
    }

    private static function getRentPropertyTrend(): array
    {
        // Données fictives pour l'exemple - à remplacer par des données réelles
        return [8, 10, 12, 14, 15, 17, 16, 14, 15];
    }

    private static function getRequestsTrend(): array
    {
        // Données fictives pour l'exemple - à remplacer par des données réelles
        return [2, 4, 6, 8, 7, 5, 4, 6, 8];
    }

    private static function getContractsTrend(): array
    {
        // Données fictives pour l'exemple - à remplacer par des données réelles
        return [5, 7, 8, 10, 12, 14, 15, 16, 18];
    }
}
