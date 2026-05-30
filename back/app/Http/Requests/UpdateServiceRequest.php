<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'                    => ['required', 'string', 'max:255'],
            'tag'                      => ['nullable', 'string', 'max:100'],
            'desc'                     => ['nullable', 'string'],
            'image'                    => ['nullable', 'string', 'max:500'],
            'sort_order'               => ['nullable', 'integer', 'min:0'],
            'translations'             => ['required', 'array'],
            'translations.uz.title'   => ['required', 'string', 'max:255'],
            'translations.uz.tag'     => ['nullable', 'string', 'max:100'],
            'translations.uz.desc'    => ['nullable', 'string'],
            'translations.en.title'   => ['required', 'string', 'max:255'],
            'translations.en.tag'     => ['nullable', 'string', 'max:100'],
            'translations.en.desc'    => ['nullable', 'string'],
        ];
    }
}
