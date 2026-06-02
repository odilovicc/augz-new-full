<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FooterLink extends Model
{
    protected $fillable = ['footer_column_id', 'label', 'href', 'position'];

    protected $casts = [
        'label' => 'array',
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(FooterColumn::class, 'footer_column_id');
    }
}
