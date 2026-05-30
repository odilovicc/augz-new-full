<?php

namespace App\Http\Requests;

use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'status'     => ['sometimes', 'required', Rule::in(MembershipApplication::$statuses)],
            'admin_note' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
