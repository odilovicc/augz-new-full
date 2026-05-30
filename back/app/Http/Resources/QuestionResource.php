<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'email'      => $this->email,
            'category'   => $this->category,
            'question'   => $this->question,
            'status'     => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
