<?php

namespace App\Services;

use App\Enums\DossierStatus;
use App\Enums\FormStep;
use App\Mail\DossierSubmittedMail;
use App\Models\CreditApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DossierService
{
    public function __construct(
        private readonly CreditCalculatorService $calculator,
        private readonly DossierReferenceGenerator $referenceGenerator,
        private readonly DossierSummaryPdfService $pdfService,
    ) {}

    public function create(array $data): CreditApplication
    {
        $mensualite = $this->calculator->mensualite($data['montant'], $data['duree_mois']);
        $totals = $this->calculator->totals($data['montant'], $data['duree_mois'], $mensualite);

        return CreditApplication::query()->create([
            'reference' => $this->referenceGenerator->generate(),
            'access_token' => (string) Str::uuid(),
            'status' => DossierStatus::Draft,
            'montant' => $data['montant'],
            'duree_mois' => $data['duree_mois'],
            'taux_annuel' => config('credit.taux_annuel'),
            'mensualite' => $mensualite,
            'cout_total' => $totals['cout_total'],
            'total_rembourse' => $totals['total_rembourse'],
            'motif' => $data['motif'] ?? null,
            'revenu_net' => isset($data['revenu_net']) ? (float) $data['revenu_net'] : null,
            'charges_mensuelles' => isset($data['charges_mensuelles']) ? (float) ($data['charges_mensuelles'] ?? 0) : null,
        ]);
    }

    public function updateStep(CreditApplication $application, FormStep $step, array $data): CreditApplication
    {
        if (! $application->isEditable()) {
            throw new ConflictHttpException('Ce dossier ne peut plus être modifié.');
        }

        $payload = match ($step) {
            FormStep::Prequal => $this->prequalPayload($data),
            FormStep::Identite => $this->identitePayload($data),
            FormStep::Situation => $this->situationPayload($application, $data),
            FormStep::Projet => $this->projetPayload($application, $data),
            FormStep::Recap => $this->recapPayload($data),
        };

        $application->fill($payload);
        $application->save();

        if ($step === FormStep::Recap) {
            return $this->submit($application);
        }

        return $application->fresh(['documents']);
    }

    public function submit(CreditApplication $application): CreditApplication
    {
        if (! $application->isEditable()) {
            throw new ConflictHttpException('Ce dossier a déjà été soumis.');
        }

        $this->assertReadyForSubmission($application);

        return DB::transaction(function () use ($application) {
            $application->status = DossierStatus::AQualifier;
            $application->submitted_at = \Illuminate\Support\Carbon::now();
            $application->processing_step = 0;
            $application->save();

            $pdfPath = $this->pdfService->generate($application);
            Mail::to($application->email)->send(new DossierSubmittedMail($application, $pdfPath));

            return $application->fresh(['documents']);
        });
    }

    public function advanceProcessing(CreditApplication $application): CreditApplication
    {
        // This method can be kept for UI simulation or removed,
        // but let's just make it return the application since we removed the Processing status for now.
        return $application;
    }

    private function assertReadyForSubmission(CreditApplication $application): void
    {
        $required = [
            FormStep::Prequal->value,
            FormStep::Identite->value,
            FormStep::Situation->value,
            FormStep::Projet->value,
            FormStep::Recap->value,
        ];

        $completed = $application->completedSteps();

        foreach ($required as $step) {
            if (! in_array($step, $completed, true)) {
                throw new UnprocessableEntityHttpException("L'étape « {$step} » est incomplète.");
            }
        }

        if (! $application->email) {
            throw new UnprocessableEntityHttpException('Une adresse e-mail valide est requise.');
        }
    }

    private function projetPayload(CreditApplication $application, array $data): array
    {
        $montant = isset($data['montant']) ? (int) $data['montant'] : $application->montant;
        $duree = isset($data['duree_mois']) ? (int) $data['duree_mois'] : $application->duree_mois;
        $mensualite = $this->calculator->mensualite($montant, $duree);
        $totals = $this->calculator->totals($montant, $duree, $mensualite);

        return [
            'motif' => $data['motif'],
            'assurance_incluse' => isset($data['assurance']) ? (bool) $data['assurance'] : true,
            'montant' => $montant,
            'duree_mois' => $duree,
            'mensualite' => $mensualite,
            'cout_total' => $totals['cout_total'],
            'total_rembourse' => $totals['total_rembourse'],
        ];
    }

    private function prequalPayload(array $data): array
    {
        $revenu = (float) $data['revenu_net'];
        $charges = (float) ($data['charges_mensuelles'] ?? 0);

        return [
            'situation_pro' => $data['situation_pro'],
            'situation_logement' => $data['situation_logement'],
            'revenu_net' => $revenu,
            'charges_mensuelles' => $charges,
            'is_eligible' => $this->calculator->isEligible($revenu, $charges),
        ];
    }

    private function identitePayload(array $data): array
    {
        return [
            'civilite' => $data['civilite'],
            'prenom' => $data['prenom'],
            'nom' => $data['nom'],
            'email' => strtolower($data['email']),
            'telephone' => preg_replace('/\s+/', '', $data['telephone']),
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'] ?? null,
            'adresse' => $data['adresse'],
            'code_postal' => $data['code_postal'],
            'ville' => $data['ville'],
        ];
    }

    private function situationPayload(CreditApplication $application, array $data): array
    {
        $requiresEmployeur = in_array($application->situation_pro, ['cdi', 'cdd', 'fonctionnaire', 'salarie_cdi', 'salarie_cdd'], true);

        if ($requiresEmployeur && empty(trim((string) ($data['employeur'] ?? '')))) {
            throw ValidationException::withMessages([
                'employeur' => ['Employeur requis pour votre situation professionnelle.'],
            ]);
        }

        return [
            'employeur' => $data['employeur'] ?? null,
            'anciennete' => $data['anciennete'],
            'situation_logement' => $data['situation_logement'] ?? $application->situation_logement,
        ];
    }

    private function recapPayload(array $data): array
    {
        return [
            'consent_1' => (bool) $data['consent_1'],
            'consent_2' => (bool) $data['consent_2'],
            'consent_3' => (bool) $data['consent_3'],
            'consented_at' => now(),
        ];
    }
}
