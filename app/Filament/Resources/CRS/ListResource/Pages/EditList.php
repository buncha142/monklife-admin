<?php

namespace App\Filament\Resources\CRS\ListResource\Pages;

use App\Filament\Resources\CRS\ListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditList extends EditRecord
{
    protected static string $resource = ListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
