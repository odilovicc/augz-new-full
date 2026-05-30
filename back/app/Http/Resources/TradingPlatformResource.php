<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradingPlatformResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $tr   = ($lang !== 'ru') ? ($this->translations[$lang] ?? []) : [];

        return [
            'id'          => $this->id,
            'name'        => $tr['name']     ?? $this->name,
            'subtitle'    => $tr['subtitle'] ?? $this->subtitle,
            'desc'        => $tr['desc']     ?? $this->desc,
            'url'         => $this->url,
            'logo'        => $this->logo,
            'logo_color'  => $this->logo_color,
            'category'    => $this->category,
            'is_official' => $this->is_official,
            'tags'        => $this->tags ?? [],
            'sort_order'  => $this->sort_order,
            'translations' => $this->translations,
        ];
    }
}
