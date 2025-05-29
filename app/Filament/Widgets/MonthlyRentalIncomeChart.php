<?php

namespace App\Filament\Widgets;

use App\Models\RentalContract;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyRentalIncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Revenus locatifs mensuels';

    protected static ?int $sort = 15;
    protected int | string | array $columnSpan = [
        'sm' => 'full',  // Pleine largeur sur mobile
        'md' => 6,       // Moitié de largeur (2 par ligne) sur tablette
        'lg' => 6,       // Moitié de largeur (2 par ligne) sur desktop
    ];

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $labels = [];
        $data = [];

        // Récupérer les 12 derniers mois
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            // Calculer le revenu mensuel pour ce mois (contrats actifs à cette date)
            $monthlyRevenue = RentalContract::where('status', 'active')
                ->where('start_date', '<=', $date->endOfMonth())
                ->where(function ($query) use ($date) {
                    $query->where('end_date', '>=', $date->startOfMonth())
                        ->orWhereNull('end_date');
                })
                ->sum('monthly_rent');

            $data[] = $monthlyRevenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenus (F CFA)',
                    'data' => $data,
                    'fill' => true,
                    'borderColor' => '#9061F9',
                    'backgroundColor' => 'rgba(144, 97, 249, 0.2)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
