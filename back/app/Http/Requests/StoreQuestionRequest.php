<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'min:2', 'max:255'],
            'phone'    => ['required', 'string', 'max:30'],
            'email'    => ['nullable', 'email', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'question' => ['required', 'string', 'min:5', 'max:2000'],
        ];
    }
}
