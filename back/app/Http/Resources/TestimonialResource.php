<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $tr   = ($this->translations ?? [])[$lang] ?? [];

        return [
            'id'           => $this->id,
            'text'         => $tr['text'] ?? $this->text,
            'author'       => $this->author,
            'role'         => $tr['role'] ?? $this->role,
            'initials'     => $this->initials,
            'avatar_color' => $this->avatar_color,
            'sort_order'   => $this->sort_order,
            'translations' => $this->when(
                $request->routeIs('admin.*') || str_contains($request->path(), 'admin'),
                $this->translations ?? []
            ),
            'created_at'   => $this->created_at->toIso8601String(),
        ];
    }
}
