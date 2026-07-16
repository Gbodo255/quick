<?php

namespace App\Http\Requests\Dossier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxKb = (int) config('credit.documents.max_size_kb');
        $mimes = config('credit.documents.mimes');

        return [
            'file' => [
                'required',
                File::types($mimes)->max($maxKb),
            ],
        ];
    }
}
