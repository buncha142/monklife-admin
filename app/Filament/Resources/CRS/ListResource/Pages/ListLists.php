<?php

namespace App\Filament\Resources\CRS\ListResource\Pages;

use App\Filament\Resources\CRS\ListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLists extends ListRecords
{
    protected static string $resource = ListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
