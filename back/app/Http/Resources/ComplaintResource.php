<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isAdmin = $request->user() !== null;

        return [
            'id'             => $this->when($isAdmin, $this->id),
            'track_code'     => $this->track_code,
            'organization'   => $this->organization,
            'tender_number'  => $this->tender_number,
            'violation_date' => $this->violation_date?->toDateString(),
            'description'    => $this->when($isAdmin, $this->description),
            'anonymous'      => $this->anonymous,
            'attachments'    => $this->when($isAdmin, $this->attachments ?? []),
            'name'           => $this->when($isAdmin, $this->name),
            'sender_org'     => $this->when($isAdmin, $this->sender_org),
            'phone'          => $this->when($isAdmin, $this->phone),
            'email'          => $this->when($isAdmin, $this->email),
            'status'           => $this->status,
            'admin_note'       => $this->when($isAdmin, $this->admin_note),
            'response_message' => $this->response_message,
            'response_files'   => $this->response_files ?? [],
            'created_at'       => $this->created_at->toIso8601String(),
            'updated_at'       => $this->updated_at->toIso8601String(),
        ];
    }
}
