<?php

namespace App\Filament\Resources\UserModsResource\Pages;

use App\Filament\Resources\UserModsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserMods extends ListRecords
{
    protected static string $resource = UserModsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
