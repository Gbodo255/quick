<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CreditApplication;
use App\Services\DossierSummaryPdfService;

$application = CreditApplication::first();
if (!$application) {
    echo "No application found.\n";
    exit(1);
}

/** @var DossierSummaryPdfService $service */
$service = $app->make(DossierSummaryPdfService::class);
$pdfPath = $service->generate($application);

echo "PDF Dossier Summary generated successfully at:\n" . $pdfPath . "\n";
echo "File size: " . filesize($pdfPath) . " bytes\n";
