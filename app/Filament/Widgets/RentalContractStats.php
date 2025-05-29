<?php

namespace App\Filament\Widgets;

use App\Models\RentalContract;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class RentalContractStats extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = 6;

    protected function getStats(): array
    {
        $activeContracts = RentalContract::where('status', 'active')->count();
        $expiringContracts = RentalContract::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(30))
            ->where('end_date', '>=', now())
            ->count();
        $totalMonthlyIncome = RentalContract::where('status', 'active')
            ->sum('monthly_rent');

        return [
            Stat::make('Contrats actifs', $activeContracts)
                ->description('Nombre total de contrats en cours')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Contrats expirant bientôt', $expiringContracts)
                ->description('Expirent dans les 30 prochains jours')
                ->descriptionIcon('heroicon-m-clock')
                ->color($expiringContracts > 0 ? 'warning' : 'gray'),

            Stat::make('Revenus mensuels', number_format($totalMonthlyIncome, 0, ',', ' ') . ' F CFA')
                ->description('Total des loyers mensuels')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Taux d\'occupation', function() {
                $totalProperties = \App\Models\Property::where('type', 'rent')->count();
                if ($totalProperties === 0) return '0%';

                $rentedProperties = \App\Models\Property::where('type', 'rent')
                    ->where('status', 'rented')
                    ->count();

                return round(($rentedProperties / $totalProperties) * 100) . '%';
            })
                ->description('Propriétés en location occupées')
                ->descriptionIcon('heroicon-m-home')
                ->color('info'),
        ];
    }
}
