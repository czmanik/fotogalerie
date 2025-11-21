<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoSlotResource\Pages;
use App\Filament\Resources\PhotoSlotResource\RelationManagers;
use App\Models\PhotoSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhotoSlotResource extends Resource
{
    protected static ?string $model = PhotoSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // app/Filament/Resources/PhotoSlotResource.php

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start_at')
                    ->label('Datum a čas focení')
                    ->required()
                    ->seconds(false), // Sekundy nejsou potřeba
                    
                Forms\Components\Toggle::make('is_booked')
                    ->label('Již obsazeno')
                    ->disabled(), // Ručně to měnit nechceme, to udělá objednávka
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime('d. m. Y - H:i')
                    ->sortable()
                    ->label('Termín'),
                    
                Tables\Columns\IconColumn::make('is_booked')
                    ->boolean()
                    ->label('Obsazeno')
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->color(fn (string $state): string => $state ? 'danger' : 'success'),
                    
                // Ukázat KDO si to rezervoval (pokud existuje zpráva)
                Tables\Columns\TextColumn::make('message.name')
                    ->label('Klient'),
            ])
            ->defaultSort('start_at', 'asc');
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
            'index' => Pages\ListPhotoSlots::route('/'),
            'create' => Pages\CreatePhotoSlot::route('/create'),
            'edit' => Pages\EditPhotoSlot::route('/{record}/edit'),
        ];
    }
}
