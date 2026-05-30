<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaderRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'                       => ['required', 'string', 'max:255'],
            'role'                       => ['required', 'string', 'max:255'],
            'photo'                      => ['nullable', 'string', 'max:500'],
            'sort_order'                 => ['nullable', 'integer', 'min:0'],
            'translations'               => ['required', 'array'],
            'translations.uz.role'       => ['required', 'string', 'max:255'],
            'translations.en.role'       => ['required', 'string', 'max:255'],
            'bio'                        => ['nullable', 'array'],
            'bio.ru'                     => ['nullable', 'string', 'max:2000'],
            'bio.uz'                     => ['nullable', 'string', 'max:2000'],
            'bio.en'                     => ['nullable', 'string', 'max:2000'],
            'social_links'               => ['nullable', 'array'],
            'social_links.*.label'       => ['required_with:social_links', 'string', 'max:100'],
            'social_links.*.url'         => ['required_with:social_links', 'string', 'max:500'],
        ];
    }
}
