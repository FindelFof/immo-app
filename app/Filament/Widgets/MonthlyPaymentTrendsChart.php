<?php

namespace App\Filament\Widgets;

use App\Models\RentPayment;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyPaymentTrendsChart extends ChartWidget
{
    protected static ?string $heading = 'Tendance des paiements mensuels';

    // Pour afficher 2 widgets par ligne
    protected int | string | array $columnSpan = 6;

    protected static ?string $maxHeight = '300px';

    protected static ?int $sort = 17;
    protected function getData(): array
    {
        $months = collect();
        $expectedData = [];
        $actualData = [];

        // Générer les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months->push($month->format('M Y'));

            // Calculer le montant attendu (contrats actifs pour ce mois * loyer mensuel)
            $expectedAmount = \App\Models\RentalContract::where('status', 'active')
                ->where('start_date', '<=', $month->endOfMonth())
                ->where(function ($query) use ($month) {
                    $query->where('end_date', '>=', $month->startOfMonth())
                        ->orWhereNull('end_date');
                })
                ->sum('monthly_rent');

            // Calculer le montant réellement perçu
            $actualAmount = RentPayment::where('status', 'paid')
                ->whereYear('due_date', $month->year)
                ->whereMonth('due_date', $month->month)
                ->sum('amount');

            $expectedData[] = $expectedAmount;
            $actualData[] = $actualAmount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Loyers attendus',
                    'data' => $expectedData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => '#3B82F6',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Loyers perçus',
                    'data' => $actualData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => '#10B981',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $months->toArray(),
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
                    'ticks' => [
                        'callback' => 'function(value) { return value.toLocaleString() + " F"; }',
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": " + context.parsed.y.toLocaleString() + " F CFA"; }',
                    ],
                ],
            ],
        ];
    }
}
