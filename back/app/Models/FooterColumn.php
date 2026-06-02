<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterColumn extends Model
{
    protected $fillable = ['title', 'position'];

    protected $casts = [
        'title' => 'array',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('position');
    }
}
