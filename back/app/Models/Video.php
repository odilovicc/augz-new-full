<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'thumbnail',
        'url',
        'badge',
        'duration',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
