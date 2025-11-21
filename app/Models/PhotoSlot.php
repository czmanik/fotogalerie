<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoSlot extends Model
{
    use HasFactory;

    protected $fillable = ['start_at', 'status', 'title', 'description', 'price'];
    
    protected $casts = [
        'start_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function message()
    {
        return $this->hasOne(Message::class);
    }
}