<?php

namespace App\Http\Requests;

use App\Models\NewsArticle;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'                    => ['required', 'string', 'max:255'],
            'excerpt'                  => ['required', 'string'],
            'content'                  => ['required', 'string'],
            'image'                    => ['nullable', 'string', 'max:255'],
            'is_featured'              => ['boolean'],
            'category'                 => ['required', Rule::in(NewsArticle::CATEGORIES)],
            'source'                   => ['nullable', 'string', 'max:128'],
            'source_url'               => ['nullable', 'url', 'max:512'],
            'tags'                     => ['nullable', 'array'],
            'tags.*'                   => ['string', 'max:64'],
            'published_at'             => ['nullable', 'date'],
            'translations'             => ['nullable', 'array'],
            'translations.uz.title'    => ['required_with:translations', 'string', 'max:255'],
            'translations.uz.excerpt'  => ['required_with:translations', 'string'],
            'translations.uz.content'  => ['required_with:translations', 'string'],
            'translations.en.title'    => ['required_with:translations', 'string', 'max:255'],
            'translations.en.excerpt'  => ['required_with:translations', 'string'],
            'translations.en.content'  => ['required_with:translations', 'string'],
        ];
    }
}
