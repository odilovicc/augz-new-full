<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'footer_column_id' => $this->footer_column_id,
            'label'            => $this->label,
            'href'             => $this->href,
            'position'         => $this->position,
        ];
    }
}
