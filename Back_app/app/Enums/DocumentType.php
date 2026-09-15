<?php

namespace App\Enums;

enum DocumentType: string
{
    case PieceIdentite = 'piece_identite';
    case Rib = 'rib';
    case CertificatScolarite = 'certificat_scolarite';
    case Contract = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::PieceIdentite => "Pièce d'identité",
            self::Rib => 'Justificatif de résidence',
            self::CertificatScolarite => 'Certificat de scolarité',
            self::Contract => 'Contrat de prêt',
        };
    }

    public function isRequired(): bool
    {
        return true;
    }
}
