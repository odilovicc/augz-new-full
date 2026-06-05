<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RegulatoryDocument extends Model
{
    const TYPES = ['law', 'decree', 'resolution', 'order'];

    protected $fillable = [
        'title', 'type', 'number', 'url', 'is_active', 'sort_order', 'translations',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'sort_order'   => 'integer',
        'translations' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
