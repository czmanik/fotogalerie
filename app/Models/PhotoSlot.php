<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoSlot extends Model
{
    use HasFactory;

    protected $fillable = ['start_at', 'is_booked'];
    
    protected $casts = [
        'start_at' => 'datetime', 
        'is_booked' => 'boolean'
    ];

    // Termín může mít jednu zprávu (objednávku)
    public function message(): HasOne
    {
        return $this->hasOne(Message::class);
    }
}