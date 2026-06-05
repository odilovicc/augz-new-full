<?php

namespace App\Http\Requests;

use App\Models\RegulatoryDocument;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegulatoryDocumentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'                    => ['sometimes', 'required', 'string', 'max:500'],
            'type'                     => ['sometimes', 'required', 'string', Rule::in(RegulatoryDocument::TYPES)],
            'number'                   => ['nullable', 'string', 'max:100'],
            'url'                      => ['sometimes', 'required', 'string', 'max:1000'],
            'is_active'                => ['boolean'],
            'sort_order'               => ['nullable', 'integer', 'min:0'],
            'translations'             => ['nullable', 'array'],
            'translations.uz.title'    => ['nullable', 'string', 'max:500'],
            'translations.en.title'    => ['nullable', 'string', 'max:500'],
        ];
    }
}
