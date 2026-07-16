<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;
use Illuminate\Validation\Rule;

class ProjetStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'motif' => ['required', 'string', Rule::in(['travaux', 'auto', 'immobilier', 'tresorerie', 'vacances', 'autre'])],
            'montant' => ['sometimes', 'integer', 'min:'.config('credit.montant_min'), 'max:'.config('credit.montant_max')],
            'duree_mois' => ['sometimes', 'integer', Rule::in(config('credit.durees_mois'))],
        ];
    }
}
