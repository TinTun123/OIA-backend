<?php

namespace App\Filament\Resources\ProgramPageResource\Pages;

use App\Filament\Resources\ProgramPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramPages extends ListRecords
{
    protected static string $resource = ProgramPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
