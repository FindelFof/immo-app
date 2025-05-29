<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RentalContractResource;
use App\Models\RentalContract;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ExpiringContractsWidget extends BaseWidget
{

    protected static ?int $sort = 13;
    protected int | string | array $columnSpan = 6;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Contrats expirant prochainement')
            ->description('Contrats de location qui expireront dans les 90 prochains jours')
            ->query(
                RentalContract::query()
                    ->where('status', 'active')
                    ->where('end_date', '<=', now()->addDays(90))
                    ->where('end_date', '>=', now())
                    ->orderBy('end_date')
            )
            ->columns([
                TextColumn::make('contract_number')
                    ->label('N° Contrat')
                    ->searchable(),
                TextColumn::make('tenant.name')
                    ->label('Locataire')
                    ->searchable(),
                TextColumn::make('property.title')
                    ->label('Propriété')
                    ->searchable(),
                TextColumn::make('monthly_rent')
                    ->label('Loyer mensuel')
                    ->money('XOF'),
                TextColumn::make('end_date')
                    ->label('Date d\'expiration')
                    ->date()
                    ->sortable(),
                TextColumn::make('days_remaining')
                    ->label('Jours restants')
                    ->getStateUsing(function (RentalContract $record): int {
                        return now()->diffInDays($record->end_date, false);
                    })
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state <= 7 => 'danger',
                        $state <= 30 => 'warning',
                        default => 'info',
                    }),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('renew')
                    ->label('Renouveler')
                    ->icon('heroicon-m-arrow-path')
                    ->url(function (RentalContract $record): string {
                        return RentalContractResource::getUrl('edit', ['record' => $record]);
                    })
                    ->openUrlInNewTab(),
            ]);
    }
}
