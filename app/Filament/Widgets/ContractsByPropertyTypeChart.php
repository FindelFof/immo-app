<?php

namespace App\Filament\Widgets;

use App\Models\RentalContract;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ContractsByPropertyTypeChart extends ChartWidget
{
    protected static ?string $heading = 'Contrats par type de bien';

    protected static ?int $sort = 14;
    protected int | string | array $columnSpan = 6;

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $data = RentalContract::join('properties', 'rental_contracts.property_id', '=', 'properties.id')
            ->where('rental_contracts.status', 'active')
            ->groupBy('properties.property_type')
            ->select('properties.property_type', DB::raw('count(*) as total'))
            ->get()
            ->mapWithKeys(function ($item) {
                $label = match($item->property_type) {
                    'house' => 'Maisons',
                    'apartment' => 'Appartements',
                    'land' => 'Terrains',
                    'commercial' => 'Commerces',
                    default => $item->property_type,
                };
                return [$label => $item->total];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Contrats actifs',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                    ],
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
