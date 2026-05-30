<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = ['slug', 'photo', 'name', 'role', 'translations', 'bio', 'social_links', 'sort_order'];
    protected $casts    = ['translations' => 'array', 'bio' => 'array', 'social_links' => 'array'];
}
