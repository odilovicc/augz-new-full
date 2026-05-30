<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingPlatform extends Model
{
    protected $fillable = [
        'name', 'subtitle', 'desc', 'url', 'logo', 'logo_color',
        'category', 'is_official', 'tags', 'translations', 'sort_order',
    ];

    protected $casts = [
        'is_official'  => 'boolean',
        'tags'         => 'array',
        'translations' => 'array',
    ];
}
