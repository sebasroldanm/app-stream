<?php

namespace App\Filament\Resources\ModsResource\Pages;

use App\Filament\Resources\ModsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMods extends EditRecord
{
    protected static string $resource = ModsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
