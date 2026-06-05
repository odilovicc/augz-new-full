<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegulatoryDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $tr   = ($lang !== 'ru') ? ($this->translations[$lang] ?? []) : [];

        return [
            'id'           => $this->id,
            'title'        => $tr['title']  ?? $this->title,
            'number'       => $this->number,
            'type'         => $this->type,
            'url'          => $this->url,
            'is_active'    => $this->is_active,
            'sort_order'   => $this->sort_order,
            'translations' => $this->translations,
        ];
    }
}
