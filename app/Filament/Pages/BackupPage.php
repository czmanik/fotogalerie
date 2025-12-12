<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Zálohování';
    protected static ?string $title = 'Záloha databáze a souborů';
    protected static string $view = 'filament.pages.backup-page';
    protected static ?string $slug = 'backup-page';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('backup_database') ?? false;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('backup_database'), 403);
    }

    public function createBackup(): void
    {
        // Zvýšíme limity pro běh skriptu, protože záloha může trvat déle
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        try {
            // Změna dle zadání: "zálohavat do podoby seederů a zároveň bude archivovat obsah v podobě fotografií"
            // Takže musíme full backup.

            Artisan::call('backup:run');

            Notification::make()
                ->title('Záloha byla úspěšně vytvořena')
                ->success()
                ->send();

        } catch (\Exception $exception) {
            Notification::make()
                ->title('Chyba při zálohování')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }

    public function downloadLatestBackup(): ?BinaryFileResponse
    {
        $backupDisk = \Illuminate\Support\Facades\Storage::disk('local');
        $appName = config('backup.backup.name');
        $directory = $appName;

        $files = $backupDisk->files($directory);

        if (empty($files)) {
             Notification::make()
                ->title('Žádná záloha k dispozici')
                ->warning()
                ->send();
            return null;
        }

        $latestBackup = collect($files)->sortByDesc(function ($file) use ($backupDisk) {
            return $backupDisk->lastModified($file);
        })->first();

        return response()->download($backupDisk->path($latestBackup));
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_backup')
                ->label('Vytvořit novou zálohu')
                ->action('createBackup')
                ->color('primary'),

            Action::make('download_backup')
                ->label('Stáhnout poslední zálohu')
                ->action('downloadLatestBackup')
                ->color('gray'),
        ];
    }
}
