<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'      => ['sometimes', 'required', 'string', 'max:255'],
            'thumbnail'  => ['nullable', 'string', 'max:500'],
            'url'        => ['sometimes', 'required', 'string', 'url', 'max:500'],
            'badge'      => ['nullable', 'string', 'max:100'],
            'duration'   => ['nullable', 'string', 'max:20'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }
}
