<?php

namespace App\Filament\Widgets;

use App\Models\RentPayment;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class PaymentCalendarWidget extends Widget
{
    protected static ?string $heading = 'Calendrier des paiements';

    protected static string $view = 'filament.widgets.payment-calendar-widget';

    protected int | string | array $columnSpan = 6;

    protected static ?int $sort = 19;

    protected function getHeading(): ?string
    {
        return 'Calendrier des paiements';
    }

    public function getViewData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $payments = RentPayment::whereBetween('due_date', [$startOfMonth, $endOfMonth])
            ->with(['rentalContract.tenant'])
            ->get()
            ->groupBy(function ($payment) {
                return $payment->due_date->format('Y-m-d');
            });

        $calendar = [];
        $currentDate = clone $startOfMonth;

        while ($currentDate <= $endOfMonth) {
            $dateString = $currentDate->format('Y-m-d');
            $calendar[$dateString] = [
                'date' => clone $currentDate,
                'isToday' => $currentDate->isToday(),
                'isWeekend' => $currentDate->isWeekend(),
                'payments' => $payments[$dateString] ?? [],
            ];

            $currentDate->addDay();
        }

        return [
            'calendar' => $calendar,
            'monthName' => Carbon::now()->format('F Y'),
        ];
    }
}
