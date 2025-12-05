<?php

namespace App\Models;

use App\Enums\PhotoSlotLocation;
use Illuminate\Database\Eloquent\Model;

class PhotoSlotTemplate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_minutes',
        'location',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'location' => PhotoSlotLocation::class,
    ];
}
