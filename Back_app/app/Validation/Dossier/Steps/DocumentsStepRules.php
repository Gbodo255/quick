<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;
use Illuminate\Validation\Rule;

class DocumentsStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'piece_identite_type' => ['required', 'string', Rule::in(['cni', 'passeport', 'titre_sejour'])],
        ];
    }
}
