<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper'; // Ikonka novin
    protected static ?string $navigationLabel = 'Napsali o mně';
    protected static ?string $navigationGroup = 'Web'; // Můžeme to seskupit
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titulek článku')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('source_name')
                    ->label('Zdroj (např. iDnes, Vogue...)')
                    ->maxLength(255),

                Forms\Components\TextInput::make('url')
                    ->label('Odkaz (URL)')
                    ->url() // Validace, že je to odkaz
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('published_at')
                    ->label('Datum vydání'),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Pořadí')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_visible')
                    ->label('Zobrazit na webu')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titulek')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('source_name')
                    ->label('Zdroj')
                    ->badge(), // Udělá z toho pěkný štítek

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Datum')
                    ->date('d. m. Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Viditelné')
                    ->boolean(),
                
                // Tlačítko pro rychlé otevření odkazu
                Tables\Columns\TextColumn::make('url')
                    ->label('Odkaz')
                    ->icon('heroicon-m-link')
                    ->formatStateUsing(fn () => 'Otevřít')
                    ->url(fn ($record) => $record->url, true) // true = otevřít v novém okně
                    ->color('info'),
            ])
            ->defaultSort('published_at', 'desc')
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
    
    public static function getRelations(): array { return []; }
}