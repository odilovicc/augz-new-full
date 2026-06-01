<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['category', 'title', 'desc', 'tags', 'translations', 'sort_order'];

    protected $casts = [
        'translations' => 'array',
        'tags'         => 'array',
    ];
}
