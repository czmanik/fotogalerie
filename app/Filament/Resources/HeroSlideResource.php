<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Hero Slider';

    protected static ?string $modelLabel = 'Slide';

    protected static ?string $pluralModelLabel = 'Hero Slides';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Grid::make(1)
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Obsah')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Nadpis')
                                            ->placeholder('MARTIN BECK')
                                            ->nullable(),

                                        Forms\Components\RichEditor::make('description')
                                            ->label('Popis')
                                            ->placeholder('Fotografie s duší')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'link',
                                                'bulletList',
                                                'redo',
                                                'undo',
                                            ])
                                            ->nullable(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('button_text')
                                                    ->label('Text tlačítka')
                                                    ->placeholder('Vstoupit do portfolia'),

                                                TextInput::make('button_url')
                                                    ->label('Odkaz (URL)')
                                                    ->url()
                                                    ->placeholder('https://...'),
                                            ]),
                                    ]),

                                Section::make('Fotografie')
                                    ->description('Nahrajte novou fotografii nebo vyberte z existujících.')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('hero')
                                            ->label('Nahrát fotografii (Hero)')
                                            ->collection('hero')
                                            ->image()
                                            ->imageEditor()
                                            ->helperText('Tato fotka se nezobrazí v galerii projektů.')
                                            ->columnSpanFull(),

                                        Select::make('photo_id')
                                            ->label('Nebo vyberte existující fotografii')
                                            ->relationship('photo', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Pokud je vybrána, použije se místo nahrané fotky. (Volitelné)'),
                                    ]),
                            ]),

                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Nastavení')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Aktivní')
                                            ->default(true),

                                        TextInput::make('display_duration')
                                            ->label('Doba zobrazení (ms)')
                                            ->numeric()
                                            ->default(5000)
                                            ->step(500)
                                            ->suffix('ms'),

                                        TextInput::make('sort_order')
                                            ->label('Pořadí')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                Section::make('Vzhled')
                                    ->schema([
                                        Select::make('layout')
                                            ->label('Rozložení')
                                            ->options([
                                                'overlay' => 'Přes celou fotku (Overlay)',
                                                'split_left' => 'Fotka vlevo / Text vpravo',
                                                'split_right' => 'Fotka vpravo / Text vlevo',
                                            ])
                                            ->default('overlay')
                                            ->required(),

                                        Select::make('content_style')
                                            ->label('Styl obsahu')
                                            ->options([
                                                'standard' => 'Standardní (bez pozadí)',
                                                'boxed' => 'V boxu (karta)',
                                            ])
                                            ->default('standard')
                                            ->required(),

                                        Select::make('text_alignment')
                                            ->label('Zarovnání textu')
                                            ->options([
                                                'left' => 'Vlevo',
                                                'center' => 'Na střed',
                                                'right' => 'Vpravo',
                                            ])
                                            ->default('center')
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('hero')
                    ->label('Foto')
                    ->collection('hero')
                    ->defaultImageUrl(fn ($record) => $record->photo ? $record->photo->getFirstMediaUrl('default', 'thumb') : null)
                    ->circular(),

                TextColumn::make('title')
                    ->label('Nadpis')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('layout')
                    ->label('Rozložení')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'overlay' => 'Overlay',
                        'split_left' => 'Vlevo',
                        'split_right' => 'Vpravo',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'overlay' => 'gray',
                        'split_left' => 'info',
                        'split_right' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('display_duration')
                    ->label('Doba')
                    ->formatStateUsing(fn ($state) => ($state / 1000) . 's')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Aktivní'),

                TextColumn::make('sort_order')
                    ->label('Pořadí')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
