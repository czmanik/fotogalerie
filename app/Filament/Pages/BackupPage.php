<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

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
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        try {
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

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function getBackups(): Collection
    {
        $backupDisk = Storage::disk('local');
        $appName = config('backup.backup.name');
        $directory = $appName;

        $files = $backupDisk->files($directory);

        $backups = collect();

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $backups->push([
                    'path' => $file,
                    'filename' => basename($file),
                    'size' => $this->formatSize($backupDisk->size($file)),
                    'date' => $backupDisk->lastModified($file),
                    'timestamp' => $backupDisk->lastModified($file),
                ]);
            }
        }

        return $backups->sortByDesc('timestamp');
    }

    protected function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function downloadBackup(string $path): BinaryFileResponse
    {
        $backupDisk = Storage::disk('local');

        if (!$backupDisk->exists($path)) {
            Notification::make()
                ->title('Soubor neexistuje')
                ->danger()
                ->send();
            abort(404);
        }

        return response()->download($backupDisk->path($path));
    }

    public function deleteBackup(string $path): void
    {
        $backupDisk = Storage::disk('local');

        if ($backupDisk->exists($path)) {
            $backupDisk->delete($path);
            Notification::make()
                ->title('Záloha byla smazána')
                ->success()
                ->send();
        }
    }

    protected function getViewData(): array
    {
        return [
            'backups' => $this->getBackups(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_backup')
                ->label('Vytvořit novou zálohu')
                ->action('createBackup')
                ->color('primary'),
        ];
    }
}
