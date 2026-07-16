<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;

class RecapStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'consent_1' => ['accepted'],
            'consent_2' => ['accepted'],
            'consent_3' => ['accepted'],
        ];
    }
}
