<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalContractResource\Pages;
use App\Models\RentalContract;
use App\Models\Property;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;

class RentalContractResource extends Resource
{
    protected static ?string $model = RentalContract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gestion Immobilière';
    protected static ?string $navigationLabel = 'Gestion des contrats';

    protected static ?string $recordTitleAttribute = 'contract_number';

    protected static ?int $navigationSort = 2;
    public static function getModelLabel(): string
    {
        return __('Contrat de location');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Contrats de location');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informations principales')
                            ->schema([
                                Forms\Components\TextInput::make('contract_number')
                                    ->label('N° de contrat')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Généré automatiquement')
                                    ->helperText('Le numéro de contrat sera généré automatiquement.')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\EditRentalContract),
                                Forms\Components\Select::make('property_id')
                                    ->label('Propriété')
                                    ->options(function () {
                                        return Property::where('type', 'rent')
                                            ->where(function ($query) {
                                                $query->where('status', 'available')
                                                    ->orWhere('status', 'rented');
                                            })
                                            ->get()
                                            ->mapWithKeys(function ($property) {
                                                return [$property->id => $property->title . ' (' . $property->address . ', ' . $property->city . ')'];
                                            });
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $property = Property::find($state);
                                            if ($property) {
                                                $set('monthly_rent', $property->price);
                                            }
                                        }
                                    })
                                    ->required(),
                                Forms\Components\Select::make('tenant_id')
                                    ->label('Locataire')
                                    ->options(function () {
                                        $tenants = User::where('role', 'tenant')->get();

                                        if ($tenants->isEmpty()) {
                                            return [];
                                        }

                                        return $tenants->mapWithKeys(function ($user) {
                                            return [$user->id => $user->name];
                                        })->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('first_name')
                                            ->label('Prénom')
                                            ->required(),
                                        Forms\Components\TextInput::make('last_name')
                                            ->label('Nom')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->unique(),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Téléphone'),
                                        Forms\Components\Hidden::make('role')
                                            ->default('tenant'),
                                        Forms\Components\Hidden::make('password')
                                            ->default(fn() => bcrypt('locataire@' . date('Y'))),
                                    ])
                                    ->createOptionUsing(function (array $data) {

                                        return User::create([
                                            'first_name' => $data['first_name'],
                                            'last_name' => $data['last_name'],
                                            'email' => $data['email'],
                                            'phone' => $data['phone'] ?? null,
                                            'role' => 'tenant',
                                            'password' => $data['password'] ?? bcrypt('locataire@' . date('Y')),
                                        ])->id;
                                    })
                                    ->required(),
                                Forms\Components\DatePicker::make('contract_date')
                                    ->label('Date de signature du contrat')
                                    ->required()
                                    ->default(now()),
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Date de début')
                                    ->required()
                                    ->default(now()),
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('Date de fin')
                                    ->required()
                                    ->helperText('Date de fin du contrat.')
                                    ->default(now()->addYear())
                                    ->afterOrEqual('start_date'),
                                Forms\Components\DatePicker::make('final_end_date')
                                    ->label('Date de fin réelle')
                                    ->default(null)
                                    ->afterOrEqual('end_date')
                                    ->helperText('Date limite jusqu\'à laquelle le contrat peut être renouvelé.'),
                                Forms\Components\TextInput::make('monthly_rent')
                                    ->label('Loyer mensuel')
                                    ->numeric()
                                    ->required()
                                    ->live()
                                    ->suffix('F CFA')
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if (is_numeric($state)) {
                                            $set('deposit', $state * 2);
                                        }
                                    })
                                    ->afterStateHydrated(function ($state, callable $set) {
                                        if (is_numeric($state)) {
                                            $set('deposit', $state * 2);
                                        }
                                    }),
                                Forms\Components\TextInput::make('deposit')
                                    ->label('Caution')
                                    ->numeric()
                                    ->required()
                                    ->helperText('Caution = 2 mois de loyer.')
                                    ->suffix('F CFA'),
                                Forms\Components\Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'active' => 'Actif',
                                        'terminated' => 'Résilié',
                                        'expired' => 'Expiré',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Frais supplémentaires')
                            ->schema([
                                Forms\Components\Repeater::make('others_fees')
                                    ->label('Frais supplémentaires')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Libellé')
                                            ->required(),
                                        Forms\Components\TextInput::make('amount')
                                            ->label('Montant')
                                            ->numeric()
                                            ->required()
                                            ->suffix('F CFA'),
                                        Forms\Components\Select::make('frequency')
                                            ->label('Fréquence')
                                            ->options([
                                                'one_time' => 'Unique',
                                                'monthly' => 'Mensuel',
                                                'quarterly' => 'Trimestriel',
                                                'yearly' => 'Annuel',
                                            ])
                                            ->default('one_time')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Description')
                                            ->rows(2),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contract_number')
                    ->label('N° de contrat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Propriété')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Locataire')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monthly_rent')
                    ->label('Loyer mensuel')
                    ->money('XOF')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Début')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'terminated',
                        'warning' => 'expired',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Actif',
                        'terminated' => 'Résilié',
                        'expired' => 'Expiré',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('rental_duration')
                    ->label('Durée')
                    ->getStateUsing(function (RentalContract $record): string {
                        $months = $record->getDurationInMonths();
                        return $months . ' ' . trans_choice('mois', $months);
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy(
                            DB::raw('DATEDIFF(end_date, start_date)'),
                            $direction
                        );
                    }),
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
                        'active' => 'Actif',
                        'terminated' => 'Résilié',
                        'expired' => 'Expiré',
                    ]),
                Tables\Filters\Filter::make('expiring_soon')
                    ->label('Expirant bientôt')
                    ->query(fn (Builder $query): Builder => $query->expiringIn30Days())
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('7xl')
                        ->using(function (Model $record, array $data): Model {
                            // Mise à jour du contrat
                            $record->update($data);

                            // Si le contrat est actif, s'assurer que la propriété est marquée comme louée
                            if ($record->status === 'active') {
                                $record->property->update(['status' => 'rented']);
                            }

                            return $record;
                        }),
                    Tables\Actions\Action::make('terminate')
                        ->label('Résilier')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (RentalContract $record) => $record->isActive())
                        ->action(function (RentalContract $record) {
                            // Résilier le contrat
                            $record->terminate();

                            // Vérifier s'il n'y a pas d'autres contrats actifs pour cette propriété
                            $hasActiveContracts = \App\Models\RentalContract::where('property_id', $record->property_id)
                                ->where('status', 'active')
                                ->where('id', '!=', $record->id)
                                ->exists();

                            // Mettre à jour le statut de la propriété uniquement s'il n'y a pas d'autres contrats actifs
                            if (!$hasActiveContracts) {
                                $record->property->update(['status' => 'available']);
                            }
                        }),
                    Tables\Actions\Action::make('renew')
                        ->label('Renouveler')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->form([
                            Forms\Components\TextInput::make('months')
                                ->label('Durée (mois)')
                                ->numeric()
                                ->default(12)
                                ->required(),
                            Forms\Components\TextInput::make('new_monthly_rent')
                                ->label('Nouveau loyer mensuel')
                                ->numeric()
                                ->suffix('F CFA')
                                ->default(function (RentalContract $record) {
                                    return $record->monthly_rent;
                                }),
                        ])
                        ->visible(fn (RentalContract $record) => $record->isActive())
                        ->action(function (RentalContract $record, array $data) {
                            // Renouveler le contrat
                            $record->renew($data['months'], $data['new_monthly_rent']);

                            // S'assurer que la propriété est toujours marquée comme louée
                            $record->property->update(['status' => 'rented']);
                        }),
                    Tables\Actions\Action::make('generate_pdf')
                        ->label('Générer PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('primary')
                        ->url(fn (RentalContract $record) => route('rental-contracts.pdf', $record))
                        ->openUrlInNewTab(),
                    /*Tables\Actions\Action::make('view_payments')
                        ->label('Voir les paiements')
                        ->icon('heroicon-o-banknotes')
                        ->color('info')
                        ->url(fn (RentalContract $record) => RentPaymentResource::getUrl('index', ['rental_contract_id' => $record->id])),
                    Tables\Actions\Action::make('create_payment')
                        ->label('Ajouter un paiement')
                        ->icon('heroicon-o-plus-circle')
                        ->color('success')
                        ->url(fn (RentalContract $record) => RentPaymentResource::getUrl('create', ['rental_contract_id' => $record->id])),*/
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListRentalContracts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['property', 'tenant']);
    }

    protected static function afterCreate(Model $record, array $data): void
    {
        $property = Property::find($data['property_id']);
        if ($property) {
            $property->update(['status' => 'rented']);
        }
    }
}
