<?php

namespace App\Filament\Resources\ServiceFormResource\Pages;

use App\Filament\Resources\ServiceFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceForm extends EditRecord
{
    protected static string $resource = ServiceFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
