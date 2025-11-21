<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'type', 'body', 
        'photo_slot_id', 'admin_note', 'reply_text', 'replied_at', 'is_read'
    ];

    protected $casts = [
        'replied_at' => 'datetime', 
        'is_read' => 'boolean'
    ];

    public function photoSlot(): BelongsTo
    {
        return $this->belongsTo(PhotoSlot::class);
    }
}