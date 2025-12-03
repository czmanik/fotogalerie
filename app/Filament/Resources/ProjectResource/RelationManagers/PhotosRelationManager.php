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
            // Řešení konfliktu "Ambiguous column":
            // Explicitně vyjmenujeme sloupce z tabulky `photos`, KROMĚ `photos.sort_order`.
            // Místo toho načteme `project_photo.sort_order` pod aliasem `sort_order`.
            // Tím zajistíme, že v celém dotazu existuje pouze jeden sloupec `sort_order` (ten z pivotu).
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) =>
                $query->select([
                    'photos.id',
                    'photos.user_id',
                    'photos.parent_id',
                    'photos.title',
                    'photos.description',
                    'photos.slug',
                    'photos.is_visible',
                    'photos.published_at',
                    'photos.exif_data',
                    'photos.captured_at',
                    'photos.created_at',
                    'photos.updated_at',
                    'photos.deleted_at',
                    'project_photo.sort_order as sort_order', // Pivot sort order
                ])
            )
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->collection('default')
                    ->conversion('thumb')
                    ->label('Náhled'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Název'),

                Tables\Columns\TextColumn::make('id') 
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->label('Viditelné'),
            ])
            ->headerActions([
                // 1. Tlačítko pro vytvoření NOVÉ fotky rovnou v projektu
                Tables\Actions\CreateAction::make()
                    ->label('Nahrát novou fotku')
                    ->modalHeading('Nahrát fotku do projektu'),

                // 2. Tlačítko pro výběr EXISTUJÍCÍ fotky (Opravené)
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple()
                    ->label('Vybrat z galerie')
                    // Co se má zobrazit jako hlavní text v seznamu (použijeme název)
                    ->recordTitleAttribute('title')
                    // TADY JE ZMĚNA: Povolíme vyhledávání podle ID i podle Názvu
                    ->recordSelectSearchColumns(['id', 'title']),
            ])
            ->actions([
                // Vlastní akce pro přechod na editaci fotky
                Tables\Actions\Action::make('edit_photo')
                    ->label('Upravit')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (\App\Models\Photo $record): string => \App\Filament\Resources\PhotoResource::getUrl('edit', ['record' => $record])),

                // Odpojení z projektu
                Tables\Actions\DetachAction::make()
                    ->label('Odebrat'),
            ]);
    }
}