<?php

namespace App\Filament\Resources\CarousalResource\Pages;

use App\Filament\Resources\CarousalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarousal extends EditRecord
{
    protected static string $resource = CarousalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
