<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute; // Pro celé jméno

class Person extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'slug', 'birth_date', 'death_date', 
        'bio', 'categories', 'avatar_photo_id'
    ];

    protected $casts = [
        'categories' => 'array', // Automaticky převádí JSON na PHP pole
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    // Virtuální atribut: Celé jméno
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Osobnost je na mnoha fotkách
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'photo_person');
    }

    // Osobnost má jednu hlavní profilovku (vybranou z fotek)
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'avatar_photo_id');
    }
}