<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Levé sloupce
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull(),

                                Forms\Components\Placeholder::make('people_list')
                                    ->label('Osobnosti v tomto projektu')
                                    ->content(function ($record) {
                                        // $record je aktuální Projekt
                                        if (!$record) return 'Uložte projekt pro zobrazení osobností.';

                                        // Získáme ID všech fotek v projektu
                                        $photoIds = $record->photos()->pluck('photos.id');
                                        
                                        // Najdeme lidi, kteří jsou na těchto fotkách (unikátně)
                                        $people = \App\Models\Person::whereHas('photos', function ($query) use ($photoIds) {
                                            $query->whereIn('photos.id', $photoIds);
                                        })->get();

                                        if ($people->isEmpty()) return 'Zatím žádné přiřazené osobnosti.';

                                        // Vypíšeme je jako seznam jmen
                                        return $people->map(fn($p) => $p->full_name . " (" . implode(', ', $p->categories ?? []) . ")")->join(', ');
                                    }),
                            ]),
                    ])->columnSpan(2),


                // Pravé sloupce (Nastavení)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Nastavení')
                            ->schema([
                                Forms\Components\Select::make('visibility')
                                    ->options([
                                        'public' => 'Veřejný',
                                        'private' => 'Soukromý',
                                        'password' => 'Zaheslovaný',
                                    ])
                                    ->default('public')
                                    ->required()
                                    ->live(), // Aby reagoval na změnu okamžitě

                                // Heslo se ukáže jen když je vybráno "Zaheslovaný"
                                Forms\Components\TextInput::make('password')
                                    ->label('Heslo k projektu')
                                    ->visible(fn (Forms\Get $get) => $get('visibility') === 'password')
                                    ->required(fn (Forms\Get $get) => $get('visibility') === 'password'),

                                // Výběr Cover fotky (z existujících)
                                Forms\Components\Select::make('cover_photo_id')
                                    ->label('Hlavní fotka (Cover)')
                                    ->relationship('coverPhoto', 'title')
                                    ->searchable()
                                    ->preload(),
                                    
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Název projektu')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('coverPhoto.title') // Ukáže název hlavní fotky
                    ->label('Cover fotka')
                    ->sortable(),

                Tables\Columns\TextColumn::make('visibility')
                    ->label('Viditelnost')
                    ->badge() // Udělá barevný štítek
                    ->color(fn (string $state): string => match ($state) {
                        'public' => 'success',   // Zelená
                        'private' => 'danger',   // Červená
                        'password' => 'warning', // Oranžová
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'public' => 'Veřejný',
                        'private' => 'Soukromý',
                        'password' => 'Zaheslovaný',
                    }),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Pořadí')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc') // Řadit podle tvého pořadí
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
            RelationManagers\PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}