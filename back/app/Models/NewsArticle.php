<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $table = 'news_articles';

    const CATEGORIES = ['news', 'analytics', 'event', 'legislation', 'investigation'];

    protected $fillable = [
        'title', 'excerpt', 'content', 'image',
        'is_featured', 'published_at', 'translations',
        'category', 'source', 'tags', 'views',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
        'translations' => 'array',
        'tags'         => 'array',
        'views'        => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    // Atomic increment — no race conditions, no full model reload
    public function incrementViews(): void
    {
        $this->newQuery()->where('id', $this->id)->increment('views');
    }
}
