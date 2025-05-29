<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class NeighborhoodPriceChart extends ChartWidget
{
    protected static ?string $heading = 'Prix moyen par quartier';

    protected static ?int $sort = 12;
    protected int | string | array $columnSpan = 6;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Récupérer les 5 quartiers les plus représentés
        $neighborhoods = Property::select('neighborhood')
            ->whereNotNull('neighborhood')
            ->groupBy('neighborhood')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->pluck('neighborhood')
            ->toArray();

        $saleData = [];
        $rentData = [];

        foreach ($neighborhoods as $neighborhood) {
            // Prix moyen pour les ventes
            $saleAvg = Property::where('type', 'sale')
                ->where('neighborhood', $neighborhood)
                ->avg('price') ?? 0;

            // Prix moyen pour les locations
            $rentAvg = Property::where('type', 'rent')
                ->where('neighborhood', $neighborhood)
                ->avg('price') ?? 0;

            $saleData[] = round($saleAvg / 1000000, 2); // En millions
            $rentData[] = round($rentAvg / 1000, 2); // En milliers
        }

        return [
            'datasets' => [
                [
                    'label' => 'Prix moyen vente (millions F CFA)',
                    'data' => $saleData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => '#3B82F6',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Prix moyen location (milliers F CFA)',
                    'data' => $rentData,
                    'backgroundColor' => 'rgba(220, 38, 38, 0.5)',
                    'borderColor' => '#DC2626',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $neighborhoods,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Prix (FCFA)',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }
}
