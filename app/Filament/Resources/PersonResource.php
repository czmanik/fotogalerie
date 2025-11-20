<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Filament\Resources\PersonResource\RelationManagers;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Základní údaje')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Jméno')
                            ->required(),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Příjmení')
                            ->required(),
                        
                        // Kategorie jako štítky (TagsInput)
                        Forms\Components\TagsInput::make('categories')
                            ->label('Kategorie (Herec, Zpěvák...)')
                            ->placeholder('Napiš a stiskni Enter')
                            ->suggestions([
                                'Herec', 'Zpěvák', 'Politik', 'Sportovec', 'Model/ka'
                            ])
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Detaily')
                    ->schema([
                        Forms\Components\DatePicker::make('birth_date')->label('Datum narození'),
                        Forms\Components\DatePicker::make('death_date')->label('Datum úmrtí'),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biografie')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Profilová fotka')
                    ->schema([
                        // Výběr fotky z již nahraných v galerii
                        Forms\Components\Select::make('avatar_photo_id')
                            ->label('Vybrat profilovku z galerie')
                            ->relationship('avatar', 'title') // Zobrazí název fotky
                            ->searchable()
                            ->preload()
                            // Zde použijeme hack s ->get()->pluck(), pokud chceš vidět i ID fotek, 
                            // nebo to necháme takto jednoduše na 'title'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Zobrazíme náhled profilovky (pokud existuje)
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar.media')
                    ->label('Foto')
                    ->collection('default')
                    ->conversion('thumb'),
                    
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable()->sortable(),
                
                // Zobrazíme kategorie jako barevné štítky
                Tables\Columns\TextColumn::make('categories')
                    ->badge()
                    ->separator(','),
                    
                Tables\Columns\TextColumn::make('photos_count')
                    ->counts('photos') // Spočítá, na kolika fotkách osoba je
                    ->label('Počet fotek'),
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
