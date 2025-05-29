<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentPaymentResource\Pages;
use App\Filament\Resources\RentPaymentResource\RelationManagers;
use App\Models\RentPayment;
use App\Models\RentalContract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RentPaymentResource extends Resource
{
    protected static ?string $model = RentPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Gestion Immobilière';

    protected static ?string $navigationLabel = 'Paiements de loyer';

    protected static ?int $navigationSort = 20;

    public static function getModelLabel(): string
    {
        return __('Paiement de loyer');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Paiements de loyer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du paiement')
                    ->schema([
                        Forms\Components\Select::make('rental_contract_id')
                            ->label('Contrat de location')
                            ->options(function () {
                                return RentalContract::where('status', 'active')
                                    ->get()
                                    ->mapWithKeys(function ($contract) {
                                        return [
                                            $contract->id =>
                                                $contract->contract_number .
                                                ' - ' .
                                                $contract->tenant->name .
                                                ' (' .
                                                $contract->property->title .
                                                ')'
                                        ];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $contract = RentalContract::find($state);
                                    if ($contract) {
                                        $set('amount', $contract->monthly_rent);
                                    }
                                }
                            }),
                        Forms\Components\DatePicker::make('due_date')
                            ->label('Date d\'échéance')
                            ->required()
                            ->default(now()),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Date de paiement')
                            ->nullable(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Montant')
                            ->required()
                            ->numeric()
                            ->suffix('F CFA'),
                        Forms\Components\Select::make('payment_method')
                            ->label('Méthode de paiement')
                            ->options(RentPayment::getPaymentMethods())
                            ->required()
                            ->default('cash'),
                        Forms\Components\TextInput::make('payment_reference')
                            ->label('Référence de paiement')
                            ->nullable()
                            ->helperText('Généré automatiquement si laissé vide'),
                        Forms\Components\Select::make('status')
                            ->label('Statut')
                            ->options([
                                'pending' => 'En attente',
                                'paid' => 'Payé',
                                'late' => 'En retard',
                            ])
                            ->required()
                            ->default('pending')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state === 'paid' && !$get('payment_date')) {
                                    $set('payment_date', now()->format('Y-m-d'));
                                }
                            }),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->nullable()
                            ->columnSpan('full'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rentalContract.contract_number')
                    ->label('N° Contrat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rentalContract.tenant.name')
                    ->label('Locataire')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rentalContract.property.title')
                    ->label('Propriété')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Échéance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Date de paiement')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Montant')
                    ->money('XOF')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Méthode')
                    ->formatStateUsing(fn (string $state): string => RentPayment::getPaymentMethods()[$state] ?? $state),
                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'paid' => 'Payé',
                        'late' => 'En retard',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'late' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_reference')
                    ->label('Référence')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'paid' => 'Payé',
                        'late' => 'En retard',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Méthode de paiement')
                    ->options(RentPayment::getPaymentMethods()),
                Tables\Filters\Filter::make('due_date')
                    ->form([
                        Forms\Components\DatePicker::make('due_from')
                            ->label('Échéance depuis'),
                        Forms\Components\DatePicker::make('due_until')
                            ->label('Échéance jusqu\'à'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['due_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                            )
                            ->when(
                                $data['due_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('rental_contract_id')
                    ->label('Contrat')
                    ->options(function () {
                        return RentalContract::all()->mapWithKeys(function ($contract) {
                            return [$contract->id => $contract->contract_number];
                        });
                    })
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('7xl'),
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('Marquer payé')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (RentPayment $record): void {
                        $record->markAsPaid(now());
                    })
                    ->visible(fn (RentPayment $record): bool => $record->status !== 'paid'),
                Tables\Actions\Action::make('download_receipt')
                    ->label('Reçu PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->url(fn (RentPayment $record): string => route('rent-payments.receipt', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (RentPayment $record): bool => $record->status === 'paid'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('Marquer comme payés')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->status !== 'paid') {
                                    $record->markAsPaid(now());
                                }
                            }
                        }),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('7xl'),
                Tables\Actions\Action::make('generate_monthly_payments')
                    ->label('Générer paiements mensuels')
                    ->icon('heroicon-o-calendar')
                    ->color('primary')
                    ->action(function (): void {
                        self::generateMonthlyPayments();
                    })
                    ->tooltip('Générer les paiements mensuels pour tous les contrats actifs'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentPayments::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'rentalContract:id,contract_number,tenant_id,property_id',
                'rentalContract.tenant:id,first_name,last_name', // Utiliser first_name et last_name au lieu de name
                'rentalContract.property:id,title'
            ]);
    }

    /**
     * Générer les paiements mensuels pour tous les contrats actifs.
     */
    public static function generateMonthlyPayments(): void
    {
        // Récupérer tous les contrats actifs
        $activeContracts = RentalContract::where('status', 'active')->get();
        $generatedCount = 0;

        // Pour chaque contrat
        foreach ($activeContracts as $contract) {
            // Calculer les paiements à générer
            $generatedCount += self::generatePaymentsForContract($contract);
        }

        // Afficher une notification avec le nombre de paiements générés
        if (class_exists('Filament\Notifications\Notification')) {
            \Filament\Notifications\Notification::make()
                ->title($generatedCount . ' paiements générés avec succès')
                ->success()
                ->send();
        }
    }

    /**
     * Générer les paiements pour un contrat spécifique.
     *
     * @return int Nombre de paiements générés
     */
    public static function generatePaymentsForContract(RentalContract $contract): int
    {
        $generatedCount = 0;

        // Date de début du contrat
        $startDate = $contract->start_date;

        // Date de fin du contrat ou date actuelle + 3 mois (pour générer les paiements futurs)
        $endDate = min($contract->end_date, now()->addMonths(3));

        // Date courante pour itération
        $currentDate = clone $startDate;

        // Générer les paiements pour chaque mois
        while ($currentDate <= $endDate) {
            // Vérifier si un paiement existe déjà pour ce mois
            $existingPayment = RentPayment::where('rental_contract_id', $contract->id)
                ->whereYear('due_date', $currentDate->year)
                ->whereMonth('due_date', $currentDate->month)
                ->first();

            // Si pas de paiement existant, en créer un
            if (!$existingPayment) {
                // Définir la date d'échéance (5 du mois)
                $dueDate = Carbon::create($currentDate->year, $currentDate->month, 5);

                // Si la date de début est après le 5, ajuster la première échéance
                if ($currentDate->day > 5 && $currentDate->month === $startDate->month && $currentDate->year === $startDate->year) {
                    $dueDate = $currentDate;
                }

                // Créer le paiement
                RentPayment::create([
                    'rental_contract_id' => $contract->id,
                    'due_date' => $dueDate,
                    'amount' => $contract->monthly_rent,
                    'status' => $dueDate < now() ? 'late' : 'pending',
                    'notes' => 'Généré automatiquement',
                ]);

                $generatedCount++;
            }

            // Passer au mois suivant
            $currentDate->addMonth();
        }

        return $generatedCount;
    }
}
