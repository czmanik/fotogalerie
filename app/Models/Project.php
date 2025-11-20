<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'visibility', 'password', 'sort_order', 'cover_photo_id'
    ];

    // Relace: Projekt má jednu hlavní (cover) fotku
    public function coverPhoto(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'cover_photo_id');
    }

    // Relace: Projekt obsahuje mnoho fotek
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'project_photo')
                    ->withPivot('sort_order') // Chceme pracovat s pořadím v pivot tabulce
                    ->orderByPivot('sort_order'); // Automaticky řadit podle pivotu
    }
}