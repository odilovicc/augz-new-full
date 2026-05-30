<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['image', 'title', 'tag', 'desc', 'translations', 'sort_order'];

    protected $casts = [
        'translations' => 'array',
    ];
}
