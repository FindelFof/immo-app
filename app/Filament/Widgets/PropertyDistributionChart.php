<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PropertyDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Répartition des propriétés';

    protected static ?int $sort = 10;
    protected int | string | array $columnSpan = [
        'sm' => 'full', // Pleine largeur sur mobile
        'md' => 6,      // Moitié de largeur sur tablette et plus grand
    ];

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $propertyTypes = ['house', 'apartment', 'land', 'commercial'];
        $labels = ['Maisons', 'Appartements', 'Terrains', 'Commerces'];

        $saleData = [];
        $rentData = [];

        foreach ($propertyTypes as $type) {
            $saleData[] = Property::where('type', 'sale')
                ->where('property_type', $type)
                ->count();

            $rentData[] = Property::where('type', 'rent')
                ->where('property_type', $type)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Propriétés à vendre',
                    'data' => $saleData,
                    'backgroundColor' => ['#1E40AF', '#3B82F6', '#60A5FA', '#93C5FD'],
                ],
                [
                    'label' => 'Propriétés à louer',
                    'data' => $rentData,
                    'backgroundColor' => ['#B91C1C', '#DC2626', '#EF4444', '#FCA5A5'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }
}
