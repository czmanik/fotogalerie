<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';
    protected static ?string $title = 'Fotografie v projektu'; // Český nadpis sekce

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort_order') // Umožní drag&drop řazení
            ->columns([
                // Náhled fotky
                SpatieMediaLibraryImageColumn::make('media')
                    ->collection('default')
                    ->conversion('thumb')
                    ->label('Náhled'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Název'),
                    
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->label('Viditelné'),
            ])
            ->headerActions([
                // Tlačítko pro výběr existujících fotek
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple()
                    ->label('Přidat fotky'),
            ])
            ->actions([
                // Tlačítko pro odebrání z projektu
                Tables\Actions\DetachAction::make()
                    ->label('Odebrat'),
            ]);
    }
}