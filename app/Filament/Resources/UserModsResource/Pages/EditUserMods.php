<?php

namespace App\Filament\Resources\UserModsResource\Pages;

use App\Filament\Resources\UserModsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserMods extends EditRecord
{
    protected static string $resource = UserModsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
