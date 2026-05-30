<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $translations = $this->translations ?? [];

        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'photo'      => $this->photo,
            'name'       => $this->name,
            'role'       => [
                'ru' => $this->role,
                'uz' => $translations['uz']['role'] ?? $this->role,
                'en' => $translations['en']['role'] ?? $this->role,
            ],
            'bio'          => [
                'ru' => $this->bio['ru'] ?? '',
                'uz' => $this->bio['uz'] ?? '',
                'en' => $this->bio['en'] ?? '',
            ],
            'social_links' => $this->social_links ?? [],
            'sort_order'   => $this->sort_order,
            'translations' => $translations,
            'created_at'   => $this->created_at->toIso8601String(),
            'updated_at'   => $this->updated_at->toIso8601String(),
        ];
    }
}
