<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;

class PropertyTypeMetrics extends ChartWidget
{
    protected static ?string $heading = 'Propriétés par type';

    protected static ?int $sort = 11;
    protected int | string | array $columnSpan = [
        'sm' => 'full', // Pleine largeur sur mobile
        'md' => 6,      // Moitié de largeur sur tablette et plus grand
    ];

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $typeLabels = [
            'house' => 'Maisons',
            'apartment' => 'Appartements',
            'land' => 'Terrains',
            'commercial' => 'Commerces'
        ];

        $data = [];
        $labels = [];
        $backgroundColors = [
            '#10B981', // vert
            '#3B82F6', // bleu
            '#F59E0B', // orange
            '#8B5CF6', // violet
        ];

        $i = 0;
        foreach ($typeLabels as $type => $label) {
            $count = Property::where('property_type', $type)->count();
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $label;
                $i++;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nombre de propriétés',
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColors, 0, $i),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
