<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Widgets\PropertyStatsOverview;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Gestion Immobilière';

    protected static ?string $navigationLabel = 'Gestion des propriétés';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return __('Propriété');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Propriétés');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informations principales')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('owner_id')
                                    ->label('Propriétaire')
                                    ->options(function () {
                                        $owners = \App\Models\User::where('role', 'owner')->get();

                                        if ($owners->isEmpty()) {
                                            return [];
                                        }

                                        return $owners->mapWithKeys(function ($user) {
                                            return [$user->id => $user->name]; // Utilise l'accesseur name que vous avez défini
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
                                            ->default('owner'),
                                        Forms\Components\Hidden::make('password')
                                            ->default(fn() => bcrypt('gfi-co@2025')),
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->label('Prix')
                                    ->required()
                                    ->numeric()
                                    ->suffix('F CFA'),
                                Forms\Components\Select::make('type')
                                    ->label('Type de transaction')
                                    ->options([
                                        'sale' => 'Vente',
                                        'rent' => 'Location',
                                    ])
                                    ->required(),
                                Forms\Components\Select::make('property_type')
                                    ->label('Type de bien')
                                    ->options([
                                        'house' => 'Maison',
                                        'apartment' => 'Appartement',
                                        'land' => 'Terrain',
                                        'commercial' => 'Commercial',
                                    ])
                                    ->required(),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Mettre en avant')
                                    ->default(false),
                                Forms\Components\Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'available' => 'Disponible',
                                        'pending' => 'En attente',
                                        'sold' => 'A Vendre',
                                        'rented' => 'Loué',
                                    ])
                                    ->default('available')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->columnSpanFull()
                                    ->rows(4),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Localisation')
                            ->schema([
                                Forms\Components\TextInput::make('city')
                                    ->label('Ville')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('address')
                                    ->label('Adresse')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('neighborhood')
                                    ->label('Quartier')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('postal_code')
                                    ->label('Code postal')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric(),
                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Caractéristiques')
                            ->schema([
                                Forms\Components\TextInput::make('rooms')
                                    ->label('Nombre de pièces')
                                    ->numeric(),
                                Forms\Components\TextInput::make('bathrooms')
                                    ->label('Nombre de salles de bain')
                                    ->numeric(),
                                Forms\Components\TextInput::make('surface')
                                    ->label('Surface (m²)')
                                    ->numeric(),
                                Forms\Components\TextInput::make('year_built')
                                    ->label('Année de construction')
                                    ->numeric(),
                                Forms\Components\CheckboxList::make('features')
                                    ->label('Équipements')
                                    ->options([
                                        'parking' => 'Parking',
                                        'garden' => 'Jardin',
                                        'pool' => 'Piscine',
                                        'balcony' => 'Balcon',
                                        'elevator' => 'Ascenseur',
                                        'security' => 'Sécurité',
                                        'air_conditioning' => 'Climatisation',
                                    ])
                                    ->columns(3)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Images')
                            ->schema([
                                Forms\Components\FileUpload::make('temp_images')
                                    ->label('Images')
                                    ->multiple()
                                    ->image()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']) // Précisez explicitement les types
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->directory('properties')
                                    ->required(fn ($record) => !$record)
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
                Tables\Columns\ImageColumn::make('property_images')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->state(function (Property $record): array {
                        $images = $record->images()->pluck('path')->toArray();

                        // Convertir les chemins relatifs en URLs absolues
                        return array_map(function($path) {
                            return asset('storage/' . $path);
                        }, $images);
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Propriétaire')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->money('XOF')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->label('Type')
                    ->colors([
                        'primary' => 'rent',
                        'success' => 'sale',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'rent' => 'Location',
                        'sale' => 'Vente',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('property_type')
                    ->badge()
                    ->label('Type de bien')
                    ->colors([
                        'primary' => 'house',
                        'secondary' => 'apartment',
                        'warning' => 'land',
                        'danger' => 'commercial',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'house' => 'Maison',
                        'apartment' => 'Appartement',
                        'land' => 'Terrain',
                        'commercial' => 'Commercial',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ville')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Statut')
                    ->colors([
                        'success' => 'available',
                        'warning' => 'pending',
                        'danger' => 'sold',
                        'secondary' => 'rented',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Disponible',
                        'pending' => 'En attente',
                        'sold' => 'Vendu',
                        'rented' => 'Loué',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('En vedette')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type de transaction')
                    ->options([
                        'sale' => 'Vente',
                        'rent' => 'Location',
                    ]),
                Tables\Filters\SelectFilter::make('property_type')
                    ->label('Type de bien')
                    ->options([
                        'house' => 'Maison',
                        'apartment' => 'Appartement',
                        'land' => 'Terrain',
                        'commercial' => 'Commercial',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'available' => 'Disponible',
                        'pending' => 'En attente',
                        'sold' => 'Vendu',
                        'rented' => 'Loué',
                    ]),
                Tables\Filters\Filter::make('is_featured')
                    ->label('En vedette')
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('7xl'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalWidth('7xl')
                    ->using(function (Model $record, array $data): Model {
                        $record->update($data);

                        // Traitement des images après la mise à jour
                        $tempImages = $data['temp_images'] ?? null;

                        if ($tempImages && is_array($tempImages) && count($tempImages) > 0) {
                            // Log pour débogage
                            Log::info('Images à sauvegarder :', ['images' => $tempImages]);

                            // Supprimer les anciennes images
                            $record->images()->delete();

                            // Ajouter les nouvelles images
                            foreach ($tempImages as $index => $path) {
                                $record->images()->create([
                                    'path' => $path,
                                    'is_featured' => ($index === 0),
                                    'display_order' => $index,
                                ]);
                            }
                        }

                        return $record;
                    }),
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
            // Vous pourriez définir des relations ici, mais comme vous utilisez des modaux,
            // cette méthode pourrait rester vide ou contenir des relations affichées dans la vue modale
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [PropertyStatsOverview::class];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['owner']);
    }
    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $tempImages = $this->data['temp_images'] ?? null;

        if ($tempImages && is_array($tempImages) && count($tempImages) > 0) {
            foreach ($tempImages as $index => $path) {
                $record->images()->create([
                    'path' => $path,
                    'is_featured' => ($index === 0), // La première image comme image principale
                    'display_order' => $index,
                ]);
            }
        }
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $tempImages = $this->data['temp_images'] ?? null;

        if ($tempImages && is_array($tempImages)) {
            // Supprimer les anciennes images
            $record->images()->delete();

            // Ajouter les nouvelles images
            foreach ($tempImages as $index => $path) {
                $record->images()->create([
                    'path' => $path,
                    'is_featured' => ($index === 0),
                    'display_order' => $index,
                ]);
            }
        }
    }
}
