<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PhoneVerificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sms_code' => ['required', 'numeric']
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
