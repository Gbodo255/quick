<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DossierResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'reference' => $this->reference,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'processing_step' => $this->processing_step,
            'completed_steps' => $this->completedSteps(),
            'simulation' => [
                'montant' => $this->montant,
                'duree_mois' => $this->duree_mois,
                'taux_annuel' => (float) $this->taux_annuel,
                'mensualite' => (float) $this->mensualite,
                'cout_total' => (float) $this->cout_total,
                'total_rembourse' => (float) $this->total_rembourse,
                'motif' => $this->motif,
                'assurance_incluse' => (bool) $this->assurance_incluse,
            ],
            'prequal' => [
                'situation_pro' => $this->situation_pro,
                'situation_logement' => $this->situation_logement,
                'revenu_net' => $this->revenu_net !== null ? (float) $this->revenu_net : null,
                'charges_mensuelles' => $this->charges_mensuelles !== null ? (float) $this->charges_mensuelles : null,
                'is_eligible' => $this->is_eligible,
            ],
            'identite' => [
                'civilite' => $this->civilite,
                'prenom' => $this->prenom,
                'nom' => $this->nom,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'date_naissance' => $this->date_naissance?->format('Y-m-d'),
                'lieu_naissance' => $this->lieu_naissance,
                'adresse' => $this->adresse,
                'code_postal' => $this->code_postal,
                'ville' => $this->ville,
            ],
            'situation' => [
                'employeur' => $this->employeur,
                'anciennete' => $this->anciennete,
            ],
            'piece_identite_type' => $this->piece_identite_type,
            'documents' => $this->whenLoaded('documents', fn () => $this->documents->map(fn ($doc) => [
                'type' => $doc->type->value,
                'label' => $doc->type->label(),
                'original_filename' => $doc->original_filename,
                'status' => $doc->status,
            ])),
            'consents' => [
                'consent_1' => $this->consent_1,
                'consent_2' => $this->consent_2,
                'consent_3' => $this->consent_3,
            ],
            'otp_verified' => $this->otp_verified_at !== null,
            'submitted_at' => $this->submitted_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
