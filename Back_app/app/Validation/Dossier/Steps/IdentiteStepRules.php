<?php

namespace App\Validation\Dossier\Steps;

use App\Validation\Dossier\Contracts\StepRules;

class IdentiteStepRules implements StepRules
{
    public function rules(): array
    {
        return [
            'civilite' => ['required', 'string', 'in:M.,Mme'],
            'prenom' => ['required', 'string', 'min:2', 'max:100'],
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['required', 'string', 'min:10', 'max:20'],
            'date_naissance' => ['required', 'date', 'before:today', 'after:1900-01-01'],
            'lieu_naissance' => ['nullable', 'string', 'max:150'],
            'adresse' => ['required', 'string', 'max:255'],
            'code_postal' => ['required', 'string', 'max:16'],
            'ville' => ['required', 'string', 'max:100'],
        ];
    }
}
