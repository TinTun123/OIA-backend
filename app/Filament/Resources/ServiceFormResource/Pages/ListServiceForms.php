<?php

namespace App\Filament\Resources\ServiceFormResource\Pages;

use App\Filament\Resources\ServiceFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceForms extends ListRecords
{
    protected static string $resource = ServiceFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
