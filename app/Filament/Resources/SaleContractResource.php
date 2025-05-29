<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleContractResource\Pages;
use App\Filament\Resources\SaleContractResource\RelationManagers;
use App\Models\SaleContract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleContractResource extends Resource
{
    protected static ?string $model = SaleContract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('contract_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('property_id')
                    ->relationship('property', 'title')
                    ->required(),
                Forms\Components\Select::make('buyer_id')
                    ->relationship('buyer', 'id')
                    ->required(),
                Forms\Components\DatePicker::make('contract_date')
                    ->required(),
                Forms\Components\DatePicker::make('sale_date')
                    ->required(),
                Forms\Components\TextInput::make('sale_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('deposit')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('payment_schedule'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contract_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('buyer.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSaleContracts::route('/'),
            'create' => Pages\CreateSaleContract::route('/create'),
            'edit' => Pages\EditSaleContract::route('/{record}/edit'),
        ];
    }
}
