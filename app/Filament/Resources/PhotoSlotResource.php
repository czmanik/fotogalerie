<?php

namespace App\Filament\Resources;

use App\Enums\PhotoSlotLocation;
use App\Filament\Resources\PhotoSlotResource\Pages;
use App\Models\PhotoSlot;
use App\Models\PhotoSlotTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;

class PhotoSlotResource extends Resource
{
    protected static ?string $model = PhotoSlot::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Termíny focení';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Termín a Status')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_at')
                            ->label('Datum a čas')
                            ->required()
                            ->seconds(false),
                            
                        Forms\Components\Select::make('status')
                            ->options([
                                'free' => 'Volno',
                                'pending' => 'Předobjednáno',
                                'confirmed' => 'Závazně rezervováno',
                            ])
                            ->required()
                            ->default('free'),
                    ])->columns(2),

                Forms\Components\Section::make('Detaily')
                    ->description('Vyberte šablonu pro rychlé vyplnění nebo zadejte údaje ručně.')
                    ->schema([
                        Forms\Components\Select::make('template_id')
                            ->label('Načíst ze šablony')
                            ->options(PhotoSlotTemplate::all()->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if (!$state) return;

                                $template = PhotoSlotTemplate::find($state);
                                if ($template) {
                                    $set('title', $template->title);
                                    $set('price', $template->price);
                                    $set('description', $template->description);
                                    $set('duration_minutes', $template->duration_minutes);
                                    $set('location', $template->location);
                                }
                            })
                            ->columnSpanFull()
                            ->helperText('Vybráním šablony se předvyplní níže uvedená pole. Údaje můžete poté upravit.'),

                        Forms\Components\TextInput::make('title')
                            ->label('Název akce')
                            ->placeholder('např. Vánoční minifocení')
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
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime('d. m. Y - H:i')
                    ->sortable()
                    ->label('Termín')
                    ->description(fn (PhotoSlot $record) => $record->title), // Pod datem se ukáže název akce
                
                Tables\Columns\TextColumn::make('price')
                    ->money('CZK')
                    ->label('Cena')
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Délka')
                    ->suffix(' min')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('location')
                    ->label('Místo')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'success',
                        'pending' => 'warning',
                        'confirmed' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'free' => 'Volno',
                        'pending' => 'Předobjednáno',
                        'confirmed' => 'Obsazeno',
                    }),
                    
                Tables\Columns\TextColumn::make('message.name')
                    ->label('Klient')
                    ->searchable(),
            ])
            ->defaultSort('start_at', 'asc')
            ->actions([
                // Tlačítko pro rychlé SCHVÁLENÍ (změní status na confirmed)
                Tables\Actions\Action::make('confirm')
                    ->label('Potvrdit')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->visible(fn (PhotoSlot $record) => $record->status === 'pending') // Vidět jen u čekajících
                    ->action(fn (PhotoSlot $record) => $record->update(['status' => 'confirmed'])),

                // Tlačítko pro UVOLNĚNÍ (změní status zpět na free)
                Tables\Actions\Action::make('cancel')
                    ->label('Zrušit rez.')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Zrušit rezervaci?')
                    ->modalDescription('Termín bude opět uvolněn pro veřejnost.')
                    ->visible(fn (PhotoSlot $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->action(function (PhotoSlot $record) {
                        $record->update(['status' => 'free']);
                        // Volitelně: Smazat i zprávu/objednávku, pokud se to uvolní?
                        // $record->message()->delete(); 
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotoSlots::route('/'),
            'create' => Pages\CreatePhotoSlot::route('/create'),
            'edit' => Pages\EditPhotoSlot::route('/{record}/edit'),
        ];
    }
}
