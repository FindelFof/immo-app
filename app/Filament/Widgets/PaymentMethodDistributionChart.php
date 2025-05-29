<?php

namespace App\Filament\Widgets;

use App\Models\RentPayment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PaymentMethodDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Répartition par méthode de paiement';

    protected static ?int $sort = 18;
    // Pour afficher 2 widgets par ligne
    protected int | string | array $columnSpan = 6;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $paymentMethods = RentPayment::where('status', 'paid')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        $labels = [];
        $counts = [];
        $colors = [
            'cash' => '#10B981', // vert
            'wave' => '#3B82F6', // bleu
            'om' => '#F59E0B', // orange
            'momo' => '#84CC16', // lime
            'moov' => '#8B5CF6', // violet
            'bank' => '#EC4899', // rose
        ];

        $backgroundColors = [];

        foreach ($paymentMethods as $method) {
            $labels[] = RentPayment::getPaymentMethods()[$method->payment_method] ?? $method->payment_method;
            $counts[] = $method->count;
            $backgroundColors[] = $colors[$method->payment_method] ?? '#6B7280'; // gris par défaut
        }

        return [
            'datasets' => [
                [
                    'label' => 'Méthodes de paiement',
                    'data' => $counts,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
