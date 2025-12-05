<?php

namespace App\Filament\Resources\PhotoSlotTemplateResource\Pages;

use App\Filament\Resources\PhotoSlotTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhotoSlotTemplate extends EditRecord
{
    protected static string $resource = PhotoSlotTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
