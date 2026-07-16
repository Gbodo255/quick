<?php

namespace App\Enums;

enum FormStep: string
{
    case Prequal = 'prequal';
    case Identite = 'identite';
    case Situation = 'situation';
    case Projet = 'projet';
    case Recap = 'recap';

    public function order(): int
    {
        return match ($this) {
            self::Prequal => 0,
            self::Identite => 1,
            self::Situation => 2,
            self::Projet => 3,
            self::Recap => 4,
        };
    }
}
