<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $translations = $this->translations ?? [];
        $tr = ($lang !== 'ru' && isset($translations[$lang])) ? $translations[$lang] : [];

        return [
            'id'           => $this->id,
            'title'        => $tr['title']   ?? $this->title,
            'excerpt'      => $tr['excerpt'] ?? $this->excerpt,
            'content'      => $tr['content'] ?? $this->content,
            'image'        => $this->resolveImage(),
            'is_featured'  => $this->is_featured,
            'category'     => $this->category,
            'source'       => $this->source,
            'tags'         => $this->tags ?? [],
            'views'        => $this->views,
            'published_at' => $this->published_at?->toIso8601String(),
            'created_at'   => $this->created_at->toIso8601String(),
            'updated_at'   => $this->updated_at->toIso8601String(),
            // Full translations only for admin endpoints
            'translations' => $this->when(
                $request->routeIs('admin.*'),
                $translations,
            ),
        ];
    }

    private function resolveImage(): string
    {
        if (!$this->image) return config('app.frontend_url', config('app.url')) . '/og-default.jpeg';
        return str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')
            ? $this->image
            : asset("storage/{$this->image}");
    }
}
