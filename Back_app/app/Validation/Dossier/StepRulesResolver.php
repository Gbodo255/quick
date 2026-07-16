<?php

namespace App\Validation\Dossier;

use App\Enums\FormStep;
use App\Validation\Dossier\Contracts\StepRules;
use App\Validation\Dossier\Steps\IdentiteStepRules;
use App\Validation\Dossier\Steps\PrequalStepRules;
use App\Validation\Dossier\Steps\ProjetStepRules;
use App\Validation\Dossier\Steps\RecapStepRules;
use App\Validation\Dossier\Steps\SituationStepRules;
use InvalidArgumentException;

class StepRulesResolver
{
    public function for(FormStep $step): StepRules
    {
        return match ($step) {
            FormStep::Prequal => new PrequalStepRules,
            FormStep::Identite => new IdentiteStepRules,
            FormStep::Situation => new SituationStepRules,
            FormStep::Projet => new ProjetStepRules,
            FormStep::Recap => new RecapStepRules,
            default => throw new InvalidArgumentException("Étape inconnue : {$step->value}"),
        };
    }
}
