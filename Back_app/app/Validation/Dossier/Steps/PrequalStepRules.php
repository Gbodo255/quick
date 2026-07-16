<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;
use Illuminate\Validation\Rule;

class PrequalStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'situation_pro' => ['required', 'string', Rule::in(['cdi', 'cdd', 'fonctionnaire', 'independant', 'retraite', 'autre', 'salarie_cdi', 'salarie_cdd'])],
            'situation_logement' => ['required', 'string', Rule::in(['proprio', 'proprietaire', 'locataire', 'heberge'])],
            'revenu_net' => ['required', 'numeric', 'min:1', 'max:999999'],
            'charges_mensuelles' => ['nullable', 'numeric', 'min:0', 'max:999999'],
        ];
    }
}
