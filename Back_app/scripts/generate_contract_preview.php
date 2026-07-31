<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CreditApplication;
use App\Services\ContractPdfService;

// Ensure we have at least one CreditApplication
$application = CreditApplication::first();
if (!$application) {
    $application = CreditApplication::create([
        'reference' => 'APP-TEST-2026',
        'civilite' => 'M.',
        'nom' => 'DUPONT',
        'prenom' => 'Jean',
        'email' => 'jean.dupont@example.com',
        'telephone' => '+33 6 12 34 56 78',
        'adresse' => '15 Rue de la Paix',
        'code_postal' => '75002',
        'ville' => 'Paris',
        'montant' => 15000.00,
        'duree_mois' => 48,
        'taux_annuel' => 3.90,
        'mensualite' => 338.05,
        'cout_total' => 16226.40,
        'motif' => 'Trésorerie / Projet Personnel',
        'status' => \App\Enums\DossierStatus::Submitted,
        'is_eligible' => true,
    ]);
}

/** @var ContractPdfService $service */
$service = $app->make(ContractPdfService::class);
$pdfPath = $service->generate($application);

echo "PDF Contract generated successfully at:\n" . $pdfPath . "\n";
echo "File size: " . filesize($pdfPath) . " bytes\n";
