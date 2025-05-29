<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Gestion des utilisateurs';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('Utilisateur');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Utilisateurs');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations personnelles')
                    ->schema([
                        Forms\Components\FileUpload::make('profile_picture')
                            ->label('Photo de profil')
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('profile-pictures')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Date de naissance')
                            ->maxDate(now()->subYears(18)),
                        Forms\Components\Select::make('role')
                            ->label('Rôle')
                            ->options([
                                'admin' => 'Administrateur',
                                'owner' => 'Propriétaire',
                                'tenant' => 'Locataire',
                                'client' => 'Client',
                            ])
                            ->required()
                            ->default('client')
                            ->searchable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Coordonnées')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Téléphone')
                            ->tel()
                            ->unique(ignorable: fn ($record) => $record),
                        Forms\Components\Textarea::make('address')
                            ->label('Adresse')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Authentification')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                            ->maxLength(255)
                            ->autocomplete('new-password'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirmer le mot de passe')
                            ->password()
                            ->dehydrated(false)
                            ->visible(fn ($get) => filled($get('password')))
                            ->required(fn ($get) => filled($get('password')))
                            ->same('password'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('identity_document')
                            ->label('Document d\'identité')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->directory('identity-documents'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom complet')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Rôle')
                    ->colors([
                        'danger' => 'admin',
                        'primary' => 'owner',
                        'warning' => 'tenant',
                        'secondary' => 'client',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrateur',
                        'owner' => 'Propriétaire',
                        'tenant' => 'Locataire',
                        'client' => 'Client',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('properties_count')
                    ->label('Propriétés')
                    ->counts('properties')
                    ->sortable()
                    ->visible(fn () => auth()->user()->role === 'admin'),
                Tables\Columns\TextColumn::make('rental_contracts_count')
                    ->label('Contrats')
                    ->counts('rentalContracts')
                    ->sortable()
                    ->visible(fn () => auth()->user()->role === 'admin'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('role')
                    ->label('Rôle')
                    ->options([
                        'admin' => 'Administrateur',
                        'owner' => 'Propriétaire',
                        'tenant' => 'Locataire',
                        'client' => 'Client',
                    ]),
                Tables\Filters\Filter::make('has_properties')
                    ->label('Avec propriétés')
                    ->query(fn (Builder $query): Builder => $query->whereHas('properties'))
                    ->toggle(),
                Tables\Filters\Filter::make('has_contracts')
                    ->label('Avec contrats')
                    ->query(fn (Builder $query): Builder => $query->whereHas('rentalContracts'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->modalWidth('7xl'),
                    Tables\Actions\EditAction::make()
                        ->modalWidth('7xl'),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('reset_password')
                        ->label('Réinitialiser le mot de passe')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('new_password')
                                ->label('Nouveau mot de passe')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->same('new_password_confirmation'),
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Confirmer le mot de passe')
                                ->password()
                                ->required(),
                        ])
                        ->action(function (User $record, array $data): void {
                            $record->update([
                                'password' => Hash::make($data['new_password']),
                            ]);
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\BulkAction::make('change_role')
                        ->label('Changer le rôle')
                        ->icon('heroicon-o-user-group')
                        ->form([
                            Forms\Components\Select::make('role')
                                ->label('Nouveau rôle')
                                ->options([
                                    'admin' => 'Administrateur',
                                    'owner' => 'Propriétaire',
                                    'tenant' => 'Locataire',
                                    'client' => 'Client',
                                ])
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'role' => $data['role'],
                                ]);
                            }
                        }),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('7xl'),
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
