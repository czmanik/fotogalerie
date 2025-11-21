<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; 
use Illuminate\Database\Eloquent\Builder;

class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Všechny zprávy'),
            
            'orders' => Tab::make('Objednávky')
                ->icon('heroicon-m-shopping-cart')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'order'))
                ->badge(fn () => \App\Models\Message::where('type', 'order')->where('is_read', false)->count()) // Počet nepřečtených
                ->badgeColor('success'),

            'questions' => Tab::make('Dotazy')
                ->icon('heroicon-m-question-mark-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'question')),
                
            'collab' => Tab::make('Spolupráce')
                ->icon('heroicon-m-users')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'collaboration')),
        ];
    }
}