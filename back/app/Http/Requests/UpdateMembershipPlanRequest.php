<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label'                    => ['sometimes', 'required', 'string', 'max:255'],
            'price'                    => ['sometimes', 'nullable', 'string', 'max:100'],
            'currency'                 => ['sometimes', 'nullable', 'string', 'max:50'],
            'period'                   => ['sometimes', 'nullable', 'string', 'max:100'],
            'is_popular'               => ['sometimes', 'boolean'],
            'cta_text'                 => ['sometimes', 'required', 'string', 'max:255'],
            'features'                 => ['sometimes', 'array'],
            'features.*.text'          => ['required', 'string', 'max:255'],
            'features.*.included'      => ['required', 'boolean'],
            'translations'             => ['sometimes', 'array'],
            'sort_order'               => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
