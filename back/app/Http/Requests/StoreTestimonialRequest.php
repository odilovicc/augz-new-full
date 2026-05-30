<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'text'         => ['required', 'string'],
            'author'       => ['required', 'string', 'max:255'],
            'role'         => ['nullable', 'string', 'max:255'],
            'initials'     => ['required', 'string', 'max:10'],
            'avatar_color' => ['nullable', 'string', 'max:255'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
        ];
    }
}
