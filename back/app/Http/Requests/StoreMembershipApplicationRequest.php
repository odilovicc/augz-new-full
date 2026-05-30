<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'plan_slug'    => ['nullable', 'string', 'max:100'],
        ];
    }
}
