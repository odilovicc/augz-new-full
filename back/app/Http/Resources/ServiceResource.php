<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', 'ru');
        $translations = $this->translations ?? [];
        $tr = ($lang !== 'ru' && isset($translations[$lang])) ? $translations[$lang] : [];

        return [
            'id'           => $this->id,
            'image'        => $this->image,
            'title'        => ['ru' => $this->title,       'uz' => $translations['uz']['title'] ?? $this->title,       'en' => $translations['en']['title'] ?? $this->title],
            'tag'          => ['ru' => $this->tag ?? '',   'uz' => $translations['uz']['tag']   ?? ($this->tag ?? ''), 'en' => $translations['en']['tag']   ?? ($this->tag ?? '')],
            'desc'         => ['ru' => $this->desc ?? '',  'uz' => $translations['uz']['desc']  ?? ($this->desc ?? ''),'en' => $translations['en']['desc']  ?? ($this->desc ?? '')],
            'sort_order'   => $this->sort_order,
            'translations' => $translations,
            'created_at'   => $this->created_at->toIso8601String(),
        ];
    }
}
