<?php

namespace App\Filament\Widgets;

use App\Models\RentPayment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class RentPaymentStats extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';

    // Pour afficher 2 widgets par ligne
    protected int | string | array $columnSpan = 6;

    protected function getStats(): array
    {
        $pendingPayments = RentPayment::where('status', 'pending')->count();
        $latePayments = RentPayment::where('status', 'late')->count();
        $paidThisMonth = RentPayment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->count();
        $totalCollectedThisMonth = RentPayment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        return [
            Stat::make('Paiements en attente', $pendingPayments)
                ->description('À percevoir')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart([4, 3, 6, 2, 5, $pendingPayments]),

            Stat::make('Paiements en retard', $latePayments)
                ->description('Nécessitent une action')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger')
                ->chart([1, 2, 3, 1, 2, $latePayments]),

            Stat::make('Paiements reçus ce mois', $paidThisMonth)
                ->description('Sur le mois en cours')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([3, 5, 7, 6, 4, $paidThisMonth]),

            Stat::make('Montant collecté ce mois', number_format($totalCollectedThisMonth, 0, ',', ' ') . ' F CFA')
                ->description('Pour ' . now()->format('F Y'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary')
                ->chart([200000, 350000, 300000, 250000, 420000, $totalCollectedThisMonth]),
        ];
    }
}
