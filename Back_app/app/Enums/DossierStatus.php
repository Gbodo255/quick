<?php

namespace App\Enums;

enum DossierStatus: string
{
    case Draft = 'draft';
    case AQualifier = 'a_qualifier';
    case DossierConforme = 'dossier_conforme';
    case MandatEnvoye = 'mandat_envoye';
    case OffreEmise = 'offre_emise';
    case FondsDecaisses = 'fonds_decaisses';
    case ClotureSucces = 'cloture_succes';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Brouillon',
            self::AQualifier => 'À Qualifier',
            self::DossierConforme => 'Dossier Conforme',
            self::MandatEnvoye => 'Mandat envoyé pour Signature',
            self::OffreEmise => 'Offre Émise',
            self::FondsDecaisses => 'Fonds Décaissés',
            self::ClotureSucces => 'Clôturé - Succès',
        };
    }
}
