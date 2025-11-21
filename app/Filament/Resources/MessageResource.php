<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // app/Filament/Resources/MessageResource.php

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- SEKCE: Co přišlo od klienta (jen pro čtení) ---
                Forms\Components\Section::make('Zpráva od klienta')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Jméno')->readonly(),
                        Forms\Components\TextInput::make('email')->label('Email')->readonly(),
                        Forms\Components\TextInput::make('phone')->label('Telefon')->readonly(),
                        
                        Forms\Components\TextInput::make('type')
                            ->label('Typ zprávy')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'order' => 'Objednávka focení',
                                'collaboration' => 'Spolupráce',
                                'question' => 'Dotaz',
                                default => 'Obecné',
                            })
                            ->readonly(),

                        // Pokud je to objednávka, ukážeme termín
                        Forms\Components\TextInput::make('photoSlot.start_at')
                            ->label('Vybraný termín')
                            ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d. m. Y H:i') : '-')
                            ->visible(fn ($record) => $record?->photoSlot_id !== null)
                            ->readonly(),

                        Forms\Components\Textarea::make('body')
                            ->label('Text zprávy')
                            ->readonly()
                            ->columnSpanFull(),
                    ])->columns(2),

                // --- SEKCE: Martinova odpověď ---
                Forms\Components\Section::make('Odpověď')
                    ->schema([
                        Forms\Components\Textarea::make('admin_note')
                            ->label('Interní poznámka (vidím jen já)')
                            ->rows(2),

                        Forms\Components\Textarea::make('reply_text')
                            ->label('Text odpovědi (bude odeslán emailem)')
                            ->helperText('Po uložení můžeš kliknout na tlačítko "Odeslat email" v seznamu.')
                            ->rows(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m. Y')->label('Přijato')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'order' => 'success',
                        'collaboration' => 'warning',
                        'question' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('replied_at')
                    ->boolean()
                    ->label('Odpovězeno')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // Tady bychom později přidali Action na skutečné odeslání emailu
                // Tables\Actions\Action::make('send_reply')...
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
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
