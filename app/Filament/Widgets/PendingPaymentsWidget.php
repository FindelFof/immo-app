<?php

namespace App\Filament\Widgets;

use App\Models\RentPayment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingPaymentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Paiements en attente';
    protected static ?int $sort = 16;

    // Pour afficher 2 widgets par ligne
    protected int | string | array $columnSpan = 6;

    protected int | string | array $maxHeight = '400px';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RentPayment::query()
                    ->where('status', 'pending')
                    ->orWhere('status', 'late')
                    ->orderBy('due_date')
                    ->with(['rentalContract.tenant', 'rentalContract.property'])
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('rentalContract.tenant.name')
                    ->label('Locataire')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Échéance')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->money('XOF')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'late' => 'En retard',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'late' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Action::make('mark_as_paid')
                    ->label('Payé')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->action(function (RentPayment $record): void {
                        $record->markAsPaid(now());
                    }),
            ]);
    }
}
