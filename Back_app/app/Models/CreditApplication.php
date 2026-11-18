<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Enums\DossierStatus;
use App\Enums\FormStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CreditApplication extends Model
{
    protected $attributes = [
        'processing_step' => 0,
        'status' => 'draft',
    ];

    protected $fillable = [
        'reference',
        'access_token',
        'status',
        'processing_step',
        'montant',
        'duree_mois',
        'taux_annuel',
        'mensualite',
        'cout_total',
        'total_rembourse',
        'situation_pro',
        'situation_logement',
        'revenu_net',
        'charges_mensuelles',
        'is_eligible',
        'civilite',
        'prenom',
        'nom',
        'email',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'code_postal',
        'ville',
        'employeur',
        'anciennete',
        'motif',
        'banque_partenaire_nom',
        'courtage_frais_dossier',
        'apport_personnel_montant',
        'assurance_incluse',
        'piece_identite_type',
        'consent_1',
        'consent_2',
        'consent_3',
        'consented_at',
        'otp_verified_at',
        'submitted_at',
        'is_archived',
        'liveness_session_id',
        'liveness_status',
        'liveness_checked_at',
    ];

    protected $casts = [
        'status' => DossierStatus::class,
        'montant' => 'integer',
        'duree_mois' => 'integer',
        'taux_annuel' => 'decimal:2',
        'mensualite' => 'decimal:2',
        'cout_total' => 'decimal:2',
        'total_rembourse' => 'decimal:2',
        'revenu_net' => 'decimal:2',
        'charges_mensuelles' => 'decimal:2',
        'courtage_frais_dossier' => 'decimal:2',
        'apport_personnel_montant' => 'decimal:2',
        'assurance_incluse' => 'boolean',
        'is_eligible' => 'boolean',
        'date_naissance' => 'date',
        'consent_1' => 'boolean',
        'consent_2' => 'boolean',
        'consent_3' => 'boolean',
        'consented_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'submitted_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(CreditApplicationDocument::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(DossierNote::class);
    }

    public function latestOtp(): HasOne
    {
        return $this->hasOne(OtpVerification::class)->latestOfMany();
    }

    public function isEditable(): bool
    {
        return $this->status === DossierStatus::Draft;
    }

    public function completedSteps(): array
    {
        $steps = [];

        if ($this->situation_pro && $this->situation_logement && $this->revenu_net !== null) {
            $steps[] = FormStep::Prequal->value;
        }

        if ($this->email && $this->prenom && $this->nom) {
            $steps[] = FormStep::Identite->value;
        }

        if ($this->anciennete) {
            $steps[] = FormStep::Situation->value;
        }

        if ($this->motif) {
            $steps[] = FormStep::Projet->value;
        }

        if ($this->consent_1 && $this->consent_2 && $this->consent_3) {
            $steps[] = FormStep::Recap->value;
        }

        return $steps;
    }
}
