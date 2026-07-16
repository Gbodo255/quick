<?php

namespace App\Http\Requests\Dossier;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'digits:'.config('credit.otp.length')],
        ];
    }
}
