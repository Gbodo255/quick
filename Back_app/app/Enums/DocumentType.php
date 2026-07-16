<?php

namespace App\Enums;

enum DocumentType: string
{
    case PieceIdentite = 'piece_identite';
    case Rib = 'rib';
    case Contract = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::PieceIdentite => "Pièce d'identité",
            self::Rib => 'RIB',
            self::Contract => 'Contrat de prêt',
        };
    }

    public function isRequired(): bool
    {
        return true;
    }
}
