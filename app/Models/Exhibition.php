<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_photo_id',
        'location',
        'description',
        'start_date',
        'end_date',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_visible' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function ($exhibition) {
            if (empty($exhibition->slug)) {
                $exhibition->slug = Str::slug($exhibition->title);
            }
        });
    }

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'exhibition_photo')
                    ->withPivot('sort_order')
                    ->orderByPivot('sort_order');
    }

    public function coverPhoto(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'cover_photo_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'exhibition_project');
    }
}