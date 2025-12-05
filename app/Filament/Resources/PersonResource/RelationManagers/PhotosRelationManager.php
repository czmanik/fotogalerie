<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Filament\Resources\PhotoResource;
use App\Models\Photo;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';
    protected static ?string $title = 'Fotografie osobnosti';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->label('Náhled')
                    ->collection('default')
                    ->conversion('thumb')
                    ->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Viditelné')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple()
                    ->label('Vybrat z galerie')
                    ->recordTitleAttribute('title')
                    ->recordSelectSearchColumns(['id', 'title']),
            ])
            ->actions([
                Action::make('set_avatar')
                    ->label('Nastavit jako profilovku')
                    ->icon('heroicon-o-user-circle')
                    ->action(function (Photo $record, \Livewire\Component $livewire) {
                        // $livewire->ownerRecord is the Person model
                        $person = $livewire->getOwnerRecord();
                        $person->avatar_photo_id = $record->id;
                        $person->save();

                        Notification::make()
                            ->title('Profilová fotka změněna')
                            ->success()
                            ->send();
                    })
                    // Hide if this photo is already the avatar
                    ->hidden(fn (Photo $record, $livewire) => $livewire->getOwnerRecord()->avatar_photo_id === $record->id),

                Action::make('edit_photo')
                    ->label('Upravit')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Photo $record): string => PhotoResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),

                Tables\Actions\DetachAction::make()
                    ->label('Odebrat'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
