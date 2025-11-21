<?php

namespace App\Filament\Resources\PhotoSlotResource\Pages;

use App\Filament\Resources\PhotoSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPhotoSlot extends EditRecord
{
    protected static string $resource = PhotoSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
