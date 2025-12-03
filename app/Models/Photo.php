<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Photo extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'parent_id',
        'title',
        'description',
        'slug',
        'is_visible',
        'published_at',
        'exif_data',
        'captured_at',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'published_at' => 'datetime',
        'captured_at' => 'datetime',
        'exif_data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($photo) {
            if (Auth::check() && !$photo->user_id) {
                $photo->user_id = Auth::id();
            }
        });

        static::saving(function ($photo) {
            if (empty($photo->slug)) {
                $baseSlug = Str::slug($photo->title ?? "photo-{$photo->id}");
                if (empty($baseSlug)) {
                    $baseSlug = "photo-" . uniqid();
                }

                $slug = $baseSlug;
                $counter = 1;

                while (Photo::where('slug', $slug)->where('id', '!=', $photo->id)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                $photo->slug = $slug;
            }
        });
    }

    public function getTitleWithIdAttribute(): string
    {
        return $this->id . ' - ' . ($this->title ?? 'Bez názvu');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_photo');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(400)
              ->height(400)
              ->sharpen(10);

        $this->addMediaConversion('medium')
              ->width(1200)
              ->responsive();

        $this->addMediaConversion('large')
              ->width(1920)
              ->height(1080);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'parent_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Photo::class, 'parent_id');
    }

    // Fotka obsahuje mnoho lidí
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'photo_person');
    }
}