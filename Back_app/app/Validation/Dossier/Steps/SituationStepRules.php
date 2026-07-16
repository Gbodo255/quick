<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;
use Illuminate\Validation\Rule;

class SituationStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'employeur' => [
                Rule::requiredIf(fn () => in_array(request()->input('situation_pro'), ['cdi', 'cdd', 'fonctionnaire', 'salarie_cdi', 'salarie_cdd'], true)),
                'nullable',
                'string',
                'max:150',
            ],
            'anciennete' => ['required', 'string', Rule::in(['moins6mois', '6a12mois', '1a3ans', '3a5ans', 'plus5ans'])],
            'situation_logement' => ['nullable', 'string', Rule::in(['proprio', 'proprietaire', 'locataire', 'heberge'])],
            'situation_pro' => ['sometimes', 'string'],
        ];
    }
}
