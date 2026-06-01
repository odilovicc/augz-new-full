<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'category'               => ['nullable', 'string', 'max:100'],
            'title'                  => ['required', 'string', 'max:255'],
            'desc'                   => ['nullable', 'string'],
            'tags'                   => ['nullable', 'array'],
            'tags.*'                 => ['string', 'max:100'],
            'sort_order'             => ['nullable', 'integer', 'min:0'],
            'translations'           => ['required', 'array'],
            'translations.uz.title'  => ['required', 'string', 'max:255'],
            'translations.uz.desc'   => ['nullable', 'string'],
            'translations.en.title'  => ['required', 'string', 'max:255'],
            'translations.en.desc'   => ['nullable', 'string'],
        ];
    }
}
