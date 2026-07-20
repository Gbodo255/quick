<?php

namespace App\Services;

use App\Models\CreditApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ContractPdfService
{
    public function __construct(
        private readonly CreditCalculatorService $calculator,
    ) {}

    public function generate(CreditApplication $application): string
    {
        $application->load('documents');

        $amortization = $this->buildAmortization($application);

        $pdf = Pdf::loadView('pdf.contract', [
            'application'  => $application,
            'brand'        => config('credit.brand'),
            'amortization' => $amortization,
            'generatedAt'  => now(),
        ])
        ->setPaper('a4');

        $relativePath = "dossiers/{$application->reference}/contrat.pdf";
        Storage::disk('local')->put($relativePath, $pdf->output());

        // Enregistrer dans la base de données pour qu'il soit visible dans l'interface
        $application->documents()->updateOrCreate(
            ['type' => \App\Enums\DocumentType::Contract],
            [
                'disk' => 'local',
                'path' => $relativePath,
                'original_filename' => "Contrat_Pret_{$application->reference}.pdf",
                'mime_type' => 'application/pdf',
                'size_bytes' => Storage::disk('local')->size($relativePath),
                'status' => 'received'
            ]
        );

        return Storage::disk('local')->path($relativePath);
    }

    /**
     * Génère les lignes du tableau d'amortissement complet.
     */
    public function buildAmortization(CreditApplication $application): array
    {
        $capital    = (float) $application->montant;
        $duree      = (int)   $application->duree_mois;
        $tauxAnnuel = (float) $application->taux_annuel;
        $mensualite = (float) $application->mensualite;

        $r = $tauxAnnuel / 100 / 12;

        $rows           = [];
        $capitalRestant = $capital;

        for ($i = 1; $i <= $duree; $i++) {
            $interets        = round($capitalRestant * $r, 2);
            $partCapital     = round($mensualite - $interets, 2);
            $capitalRestant  = round($capitalRestant - $partCapital, 2);

            $rows[] = [
                'mois'            => $i,
                'mensualite'      => $mensualite,
                'interets'        => $interets,
                'part_capital'    => $partCapital,
                'capital_restant' => max(0, $capitalRestant),
            ];
        }

        return $rows;
    }
}
