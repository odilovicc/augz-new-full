<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $translations = $this->translations ?? [];

        return [
            'id'         => $this->id,
            'category'   => $this->category ?? '',
            'title'      => ['ru' => $this->title, 'uz' => $translations['uz']['title'] ?? $this->title, 'en' => $translations['en']['title'] ?? $this->title],
            'desc'       => ['ru' => $this->desc ?? '', 'uz' => $translations['uz']['desc'] ?? ($this->desc ?? ''), 'en' => $translations['en']['desc'] ?? ($this->desc ?? '')],
            'tags'       => $this->tags ?? [],
            'sort_order' => $this->sort_order,
            'translations' => $translations,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
