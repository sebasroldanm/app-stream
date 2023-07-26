<?php

namespace App\Filament\Resources\ModsResource\Pages;

use App\Filament\Resources\ModsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMods extends ListRecords
{
    protected static string $resource = ModsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
