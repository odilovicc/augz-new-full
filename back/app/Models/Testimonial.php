<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['text', 'author', 'role', 'initials', 'avatar_color', 'translations', 'sort_order'];

    protected $casts = [
        'translations' => 'array',
    ];
}
