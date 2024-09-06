<?php

namespace App\Http\Requests\Evens;

use Illuminate\Foundation\Http\FormRequest;

class EventNewsletterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['nullable', 'max:100'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
