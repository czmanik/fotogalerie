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
            // Řešení konfliktu "Ambiguous column":
            // Explicitně vyjmenujeme sloupce z tabulky `photos`, KROMĚ `photos.sort_order` (pokud by existoval).
            // Hlavně načteme `photo_person.sort_order` pod aliasem `sort_order`.
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) =>
                $query->select([
                    'photos.id',
                    'photos.user_id',
                    'photos.parent_id',
                    'photos.title',
                    'photos.description',
                    'photos.slug',
                    'photos.is_visible',
                    'photos.published_at',
                    'photos.exif_data',
                    'photos.captured_at',
                    'photos.created_at',
                    'photos.updated_at',
                    'photos.deleted_at',
                    'photo_person.sort_order as sort_order', // Pivot sort order
                ])
            )
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->collection('default')
                    ->conversion('thumb')
                    ->label('Náhled'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->label('Viditelné'),
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
                    ->recordSelectSearchColumns(['id', 'title'])
                    // Hook to ensure the new photo is added as the last one
                    ->after(function ($livewire, $record) {
                        // $livewire->getOwnerRecord() is the Person
                        // $record is the attached Photo
                        $person = $livewire->getOwnerRecord();
                        // Find the current max sort order for this person's photos
                        $maxOrder = $person->photos()->max('photo_person.sort_order') ?? 0;

                        // Update the pivot record for the newly attached photo
                        // We use updateExistingPivot to target the specific relation
                        $person->photos()->updateExistingPivot($record->id, [
                            'sort_order' => $maxOrder + 1
                        ]);
                    }),
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
