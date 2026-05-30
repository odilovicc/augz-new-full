<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $tr   = ($this->translations ?? [])[$lang] ?? [];

        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'label'      => $tr['label']    ?? $this->label,
            'price'      => $this->price,
            'currency'   => $tr['currency'] ?? $this->currency,
            'period'     => $tr['period']   ?? $this->period,
            'is_popular' => $this->is_popular,
            'cta_text'   => $tr['cta_text'] ?? $this->cta_text,
            'features'   => $tr['features'] ?? $this->features ?? [],
            'sort_order' => $this->sort_order,
            // admin needs full translations for editing
            'translations' => $this->when(
                $request->routeIs('admin.*') || str_contains($request->path(), 'admin'),
                $this->translations ?? []
            ),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
