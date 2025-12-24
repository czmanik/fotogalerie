<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Výstavy';
    protected static ?string $navigationGroup = 'Web';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informace o výstavě')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Název výstavy')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\TextInput::make('location')
                            ->label('Místo konání')
                            ->required()
                            ->placeholder('např. Galerie Mánes, Praha'),
                            
                        Forms\Components\RichEditor::make('description')
                            ->label('Popis')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Termín a nastavení')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Začátek')
                            ->required(),
                            
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Konec')
                            ->helperText('Nechte prázdné pro stálou expozici')
                            ->afterOrEqual('start_date'), // Validace
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                            
                        Forms\Components\Toggle::make('is_visible')
                            ->label('Zobrazit na webu')
                            ->default(true),

                        Forms\Components\Select::make('cover_photo_id')
                            ->label('Hlavní fotka (Cover)')
                            ->relationship('coverPhoto', 'title')
                            ->searchable()
                            ->preload()
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
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Místo')
                    ->icon('heroicon-m-map-pin')
                    ->searchable(),

                // Spojíme datumy do jednoho sloupce
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Termín')
                    ->formatStateUsing(function ($record) {
                        $start = $record->start_date->format('d.m.Y');
                        $end = $record->end_date ? $record->end_date->format('d.m.Y') : 'trvá';
                        return "$start - $end";
                    }),

                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->label('Viditelné'),
            ])
            ->defaultSort('start_date', 'desc') // Nejnovější nahoře
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExhibitions::route('/'),
            'create' => Pages\CreateExhibition::route('/create'),
            'edit' => Pages\EditExhibition::route('/{record}/edit'),
        ];
    }
    
    public static function getRelations(): array {
        return [
            ExhibitionResource\RelationManagers\PhotosRelationManager::class,
        ];
    }
}