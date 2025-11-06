<?php

namespace App\Filament\Resources\CarousalResource\Pages;

use App\Filament\Resources\CarousalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarousals extends ListRecords
{
    protected static string $resource = CarousalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
