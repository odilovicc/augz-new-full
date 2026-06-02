<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterColumnResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'position' => $this->position,
            'links'    => FooterLinkResource::collection($this->whenLoaded('links')),
        ];
    }
}
