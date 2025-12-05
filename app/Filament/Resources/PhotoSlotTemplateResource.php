<?php

namespace App\Filament\Resources;

use App\Enums\PhotoSlotLocation;
use App\Filament\Resources\PhotoSlotTemplateResource\Pages;
use App\Models\PhotoSlotTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PhotoSlotTemplateResource extends Resource
{
    protected static ?string $model = PhotoSlotTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationLabel = 'Šablony termínů';
    protected static ?string $pluralModelLabel = 'Šablony termínů';
    protected static ?string $modelLabel = 'Šablona termínu';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Nastavení šablony')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Název')
                            ->placeholder('např. Vánoční minifocení')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Cena (Kč)')
                            ->numeric()
                            ->prefix('Kč'),

                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Délka focení (minut)')
                            ->numeric()
                            ->suffix('min'),

                        Forms\Components\Select::make('location')
                            ->label('Místo focení')
                            ->options(PhotoSlotLocation::class),

                        Forms\Components\Textarea::make('description')
                            ->label('Popis / Poznámka pro klienta')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Cena')
                    ->money('CZK')
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Délka')
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Místo')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotoSlotTemplates::route('/'),
            'create' => Pages\CreatePhotoSlotTemplate::route('/create'),
            'edit' => Pages\EditPhotoSlotTemplate::route('/{record}/edit'),
        ];
    }
}
