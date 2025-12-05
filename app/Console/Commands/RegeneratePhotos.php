<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RegeneratePhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:regenerate-clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate media conversions for photos with high memory limit and garbage collection.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Nastavit vysoký limit paměti
        ini_set('memory_limit', '2048M');
        $this->info('Memory limit set to 2048M.');

        $photosCount = Photo::count();
        $this->info("Found {$photosCount} photos to process.");

        $bar = $this->output->createProgressBar($photosCount);

        // Použijeme cursor() pro minimalizaci paměti při načítání modelů
        foreach (Photo::cursor() as $photo) {

            // Získat média
            $mediaItems = $photo->getMedia('default');

            foreach ($mediaItems as $media) {
                try {
                    // Volitelné: Smazat existující resposive images, aby se vyčistil "bordel"
                    // (Spatie to obvykle dělá při regeneraci, ale pro jistotu)
                    // $media->deleteResponsiveImages(); // Metoda nemusí existovat veřejně v starších verzích, zkusíme bez toho

                    // Vynutit regeneraci
                    // Použijeme manipulátory definované v modelu (thumb, medium, large)
                    // Díky 'nonQueued' v modelu se to provede hned.
                    $media->manipulations = []; // Reset manipulací? Ne, chceme conversions.

                    // Spatie metoda pro regeneraci
                    // Toto zavolá createMediaConversions a generateResponsiveImages
                    $this->call('media-library:regenerate', [
                        '--ids' => $media->id,
                        '--force' => true, // Vynutit i když existují
                    ]);

                } catch (\Exception $e) {
                    $this->error("Error processing photo ID {$photo->id}: " . $e->getMessage());
                }
            }

            // Uvolnit paměť
            unset($photo);
            unset($mediaItems);

            // Explicitní GC
            if ($bar->getProgress() % 10 === 0) {
                gc_collect_cycles();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Regeneration complete.');
    }
}
