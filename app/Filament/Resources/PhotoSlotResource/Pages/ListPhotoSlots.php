<?php

namespace App\Filament\Resources\PhotoSlotResource\Pages;

use App\Filament\Resources\PhotoSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhotoSlots extends ListRecords
{
    protected static string $resource = PhotoSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
