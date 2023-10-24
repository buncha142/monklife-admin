<?php

namespace App\Filament\Resources\NTFY\NtfyResource\Pages;

use App\Filament\Resources\NTFY\NtfyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNtfies extends ListRecords
{
    protected static string $resource = NtfyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
