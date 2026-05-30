<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'organization' => $this->organization,
            'phone'        => $this->phone,
            'email'        => $this->email,
            'plan_slug'    => $this->plan_slug,
            'status'       => $this->status,
            'admin_note'   => $this->admin_note,
            'created_at'   => $this->created_at->toIso8601String(),
            'updated_at'   => $this->updated_at->toIso8601String(),
        ];
    }
}
