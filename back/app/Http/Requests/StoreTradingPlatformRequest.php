<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTradingPlatformRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'                      => ['required', 'string', 'max:255'],
            'subtitle'                  => ['nullable', 'string', 'max:255'],
            'desc'                      => ['nullable', 'string'],
            'url'                       => ['required', 'string', 'max:500'],
            'logo'                      => ['nullable', 'string', 'max:500'],
            'logo_color'                => ['nullable', 'string', 'max:20'],
            'category'                  => ['required', 'string', 'in:government,corporate,aggregator,international'],
            'is_official'               => ['boolean'],
            'tags'                      => ['nullable', 'array'],
            'tags.*'                    => ['string', 'max:100'],
            'sort_order'                => ['nullable', 'integer', 'min:0'],
            'translations'              => ['nullable', 'array'],
            'translations.uz.name'      => ['nullable', 'string', 'max:255'],
            'translations.uz.subtitle'  => ['nullable', 'string', 'max:255'],
            'translations.uz.desc'      => ['nullable', 'string'],
            'translations.en.name'      => ['nullable', 'string', 'max:255'],
            'translations.en.subtitle'  => ['nullable', 'string', 'max:255'],
            'translations.en.desc'      => ['nullable', 'string'],
        ];
    }
}
