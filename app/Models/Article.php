<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'source_name',
        'published_at',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_visible' => 'boolean',
    ];
}