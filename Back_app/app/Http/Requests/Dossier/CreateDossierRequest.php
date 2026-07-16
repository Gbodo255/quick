<?php

namespace App\Http\Requests\Dossier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDossierRequest extends FormRequest
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
            'motif' => ['nullable', 'string', Rule::in(['travaux', 'auto', 'immobilier', 'tresorerie', 'vacances', 'autre'])],
            'revenu_net' => ['nullable', 'numeric', 'min:0'],
            'charges_mensuelles' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
