<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'slug', 'label', 'price', 'currency', 'period',
        'is_popular', 'cta_text', 'features', 'translations', 'sort_order',
    ];

    protected $casts = [
        'is_popular'   => 'boolean',
        'features'     => 'array',
        'translations' => 'array',
    ];
}
