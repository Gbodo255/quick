<?php

namespace App\Http\Requests\Dossier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimulateCreditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'montant' => ['required', 'integer', 'min:'.config('credit.montant_min'), 'max:'.config('credit.montant_max')],
            'duree_mois' => ['required', 'integer', Rule::in(config('credit.durees_mois'))],
        ];
    }
}
