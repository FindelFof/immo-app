<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Filament\Widgets\PropertyStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('7xl')
                ->before(function (array $data): void {
                    Log::info('Avant création :', ['data' => $data]);
                })
                ->after(function (Model $record, array $data): void {
                    $tempImages = $data['temp_images'] ?? null;

                    if ($tempImages && is_array($tempImages) && count($tempImages) > 0) {
                        // Log pour débogage
                        Log::info('Images à créer :', ['images' => $tempImages]);

                        // Ajouter les images
                        foreach ($tempImages as $index => $path) {
                            $record->images()->create([
                                'path' => $path,
                                'is_featured' => ($index === 0),
                                'display_order' => $index,
                            ]);
                        }
                    }
                }),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PropertyStatsOverview::class,
        ];
    }
}
