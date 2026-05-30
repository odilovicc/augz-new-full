<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    protected $fillable = [
        'track_code',
        'organization',
        'tender_number',
        'violation_date',
        'description',
        'anonymous',
        'name',
        'sender_org',
        'phone',
        'email',
        'status',
        'admin_note',
        'response_message',
        'response_files',
        'attachments',
    ];

    protected $casts = [
        'anonymous'      => 'boolean',
        'violation_date' => 'date',
        'response_files' => 'array',
        'attachments'    => 'array',
    ];

    public static array $statuses = [
        'new',
        'analyzing',
        'investigating',
        'forming_response',
        'official_response',
        'closed',
    ];

    public static function generateTrackCode(): string
    {
        $date = now()->format('Y-m');
        do {
            $code = 'DXU-' . $date . '-' . random_int(1000, 9999);
        } while (self::where('track_code', $code)->exists());

        return $code;
    }
}
