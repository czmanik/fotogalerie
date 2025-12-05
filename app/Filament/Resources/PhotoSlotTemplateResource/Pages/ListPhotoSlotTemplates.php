<?php

namespace App\Filament\Resources\PhotoSlotTemplateResource\Pages;

use App\Filament\Resources\PhotoSlotTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhotoSlotTemplates extends ListRecords
{
    protected static string $resource = PhotoSlotTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
