<?php

namespace App\Filament\Resources\CRS\CarResource\Pages;

use App\Filament\Resources\CRS\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
