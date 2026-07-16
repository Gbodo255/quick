<?php

namespace App\Services;

use App\Models\CreditApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DossierSummaryPdfService
{
    public function generate(CreditApplication $application): string
    {
        $application->load('documents');

        $pdf = Pdf::loadView('pdf.dossier-summary', [
            'application' => $application,
            'brand' => config('credit.brand'),
        ])->setPaper('a4');

        $relativePath = "dossiers/{$application->reference}/recapitulatif.pdf";
        Storage::disk('local')->put($relativePath, $pdf->output());

        return Storage::disk('local')->path($relativePath);
    }
}
