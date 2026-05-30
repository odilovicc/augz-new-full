<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'text'         => ['sometimes', 'required', 'string'],
            'author'       => ['sometimes', 'required', 'string', 'max:255'],
            'role'         => ['sometimes', 'nullable', 'string', 'max:255'],
            'initials'     => ['sometimes', 'required', 'string', 'max:10'],
            'avatar_color' => ['sometimes', 'nullable', 'string', 'max:255'],
            'sort_order'   => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
