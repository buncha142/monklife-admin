<?php

namespace App\Filament\Resources\NTFY\NtfyResource\Pages;

use App\Filament\Resources\NTFY\NtfyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNtfy extends EditRecord
{
    protected static string $resource = NtfyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
