<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyAlertResource\Pages;
use App\Filament\Resources\PropertyAlertResource\RelationManagers;
use App\Models\PropertyAlert;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyAlertResource extends Resource
{
    protected static ?string $model = PropertyAlert::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Forms\Components\TextInput::make('property_type'),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('min_price')
                    ->numeric(),
                Forms\Components\TextInput::make('max_price')
                    ->numeric(),
                Forms\Components\TextInput::make('min_rooms')
                    ->numeric(),
                Forms\Components\TextInput::make('min_bathrooms')
                    ->numeric(),
                Forms\Components\TextInput::make('min_surface')
                    ->numeric(),
                Forms\Components\TextInput::make('features'),
                Forms\Components\TextInput::make('type'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('property_type'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('min_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_rooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_bathrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_surface')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPropertyAlerts::route('/'),
            'create' => Pages\CreatePropertyAlert::route('/create'),
            'edit' => Pages\EditPropertyAlert::route('/{record}/edit'),
        ];
    }
}
