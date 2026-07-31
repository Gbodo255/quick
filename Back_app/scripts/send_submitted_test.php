<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CreditApplication;
use App\Mail\DossierSubmittedMail;
use Illuminate\Support\Facades\Mail;

$application = CreditApplication::first() ?? new CreditApplication([
    'reference' => 'CR-TEST-999',
    'prenom' => 'Chris',
    'nom' => 'Maoule',
    'email' => 'chrisvianneymaoule@gmail.com',
    'montant' => 25000,
    'duree_mois' => 48,
    'mensualite' => 562.45,
    'taux_annuel' => 3.9,
]);

$recipient = 'chrisvianneymaoule@gmail.com';
echo "Envoi du mail de confirmation de dossier avec signature Julien Verran...\n";

try {
    Mail::to($recipient)->send(new DossierSubmittedMail($application));
    echo "✅ Mail envoyé avec succès à {$recipient} !\n";
} catch (\Throwable $e) {
    echo "❌ Erreur d'envoi : " . $e->getMessage() . "\n";
}
