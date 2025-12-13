<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;
    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationLabel = 'Fotografie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- Sekce OBRÁZEK ---
                SpatieMediaLibraryFileUpload::make('media')
                    ->label('Fotografie')
                    ->collection('default')
                    ->responsiveImages()
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/tiff'])
                    ->columnSpanFull(),

                // --- Sekce TEXTY ---
                TextInput::make('title')
                    ->label('Název')
                    ->required(),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->unique(ignoreRecord: true)
                    ->helperText('Nechte prázdné pro automatické vygenerování.'),

                RichEditor::make('description')
                    ->label('Popis')
                    ->columnSpanFull(),

                // --- Sekce NASTAVENÍ ---
                Select::make('parent_id')
                    ->label('Je variantou fotky')
                    ->relationship('parent', 'title')
                    ->searchable()
                    ->preload()
                    ->placeholder('Vyberte hlavní fotku (pokud toto je varianta)'),

                Select::make('projects')
                ->label('Přiřadit do projektů')
                ->relationship('projects', 'title') // Vazba na projekty
                ->multiple() // Fotka může být ve více projektech
                ->preload()
                ->searchable()
                ->columnSpanFull(), // Aby to bylo přes celou šířku

                Forms\Components\Select::make('people')
                ->label('Osobnosti na fotce')
                ->relationship('people', 'last_name') // Hledat podle příjmení
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                ->multiple() // Může jich tam být víc
                ->preload()
                ->searchable()
                ->createOptionForm([ // Rychlé vytvoření nové osoby přímo z fotky!
                    Forms\Components\TextInput::make('first_name')->required(),
                    Forms\Components\TextInput::make('last_name')->required(),
                    Forms\Components\TagsInput::make('categories'),
                ])
                ->columnSpanFull(),

                Toggle::make('is_visible')
                    ->label('Zveřejnit na webu')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->label('Náhled')
                    ->collection('default')
                    ->conversion('thumb')
                    ->height(60),

                TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('parent.title')
                    ->label('Hlavní fotka')
                    ->description('Pokud vyplněno, toto je varianta')
                    ->sortable(),

                IconColumn::make('is_visible')
                    ->label('Viditelné')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('sort_order')
                    ->label('Pořadí')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}