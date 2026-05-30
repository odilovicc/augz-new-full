<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'organization'   => ['nullable', 'string', 'max:255'],
            'tender_number'  => ['nullable', 'string', 'max:100'],
            'violation_date' => ['nullable', 'date'],
            'description'    => ['required', 'string', 'min:10'],
            'anonymous'      => ['boolean'],
            'name'           => ['nullable', 'string', 'max:255'],
            'sender_org'     => ['nullable', 'string', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:50'],
            'email'          => ['nullable', 'email', 'max:255'],
            'attachments'    => ['nullable', 'array', 'max:5'],
            'attachments.*'  => ['file', 'mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx', 'max:10240'],
        ];
    }
}
