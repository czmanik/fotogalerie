<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Photo;
use Illuminate\Support\Str;

class GeneratePhotoSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate missing slugs for photos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $photos = Photo::whereNull('slug')->orWhere('slug', '')->get();

        $this->info("Found {$photos->count()} photos without slugs.");

        foreach ($photos as $photo) {
            $baseSlug = Str::slug($photo->title ?? "photo-{$photo->id}");

            if (empty($baseSlug)) {
                $baseSlug = "photo-{$photo->id}";
            }

            $slug = $baseSlug;
            $counter = 1;

            while (Photo::where('slug', $slug)->where('id', '!=', $photo->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            $photo->slug = $slug;
            $photo->save();

            $this->info("Generated slug for photo ID {$photo->id}: {$slug}");
        }

        $this->info('Slug generation complete.');
    }
}
