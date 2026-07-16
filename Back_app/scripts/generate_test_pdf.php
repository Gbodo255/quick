<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\CreditApplication;
use App\Services\DossierSummaryPdfService;
use Illuminate\Contracts\Console\Kernel;

$application = CreditApplication::query()->first();
if (! $application) {
    echo "No CreditApplication found. Create one before running test.\n";
    exit(2);
}

/** @var DossierSummaryPdfService $svc */
$svc = $app->make(DossierSummaryPdfService::class);
$path = $svc->generate($application);

echo 'PDF generated: '.$path."\n";
