<?php

namespace App\Http\Requests\Evens\EventRegistration;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['nullable', 'max:100'],
            'additional_fields_json' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
