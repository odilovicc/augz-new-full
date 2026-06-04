<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavbarLink extends Model
{
    protected $fillable = ['label', 'href', 'position'];

    protected $casts = [
        'label' => 'array',
    ];
}
