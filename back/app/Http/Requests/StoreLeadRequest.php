<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'min:2', 'max:255'],
            'phone'  => ['required', 'string', 'max:30'],
            'email'  => ['nullable', 'email', 'max:255'],
            'source'  => ['nullable', 'string', 'max:100'],
            'service' => ['nullable', 'string', 'max:255'],
            'type'    => ['nullable', 'in:free,demo'],
        ];
    }
}
