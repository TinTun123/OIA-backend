<?php

namespace App\Filament\Resources\ProgramPageResource\Pages;

use App\Filament\Resources\ProgramPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramPage extends EditRecord
{
    protected static string $resource = ProgramPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
