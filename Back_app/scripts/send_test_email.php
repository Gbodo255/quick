<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

$recipient = 'chrisvianneymaoule@gmail.com';
$from = config('mail.from.address');
$mailer = config('mail.default');

echo "Tentative d'envoi d'e-mail de test...\n";
echo "Mailer: {$mailer}\n";
echo "Host: " . config('mail.mailers.smtp.host') . "\n";
echo "Port: " . config('mail.mailers.smtp.port') . "\n";
echo "Expéditeur: {$from}\n";
echo "Destinataire: {$recipient}\n\n";

try {
    Mail::raw("Bonjour,\n\nCeci est un e-mail de test envoyé depuis le système CreditEco (support@crediteco.app) pour valider la configuration d'envoi d'e-mails.\n\nCordialement,\nL'équipe CreditEco", function ($message) use ($recipient, $from) {
        $message->to($recipient)
                ->from($from, 'CreditEco Support')
                ->subject('Test d\'envoi d\'e-mail - CreditEco');
    });

    echo "✅ E-mail envoyé avec succès à {$recipient} !\n";
} catch (\Throwable $e) {
    echo "❌ Échec de l'envoi de l'e-mail :\n";
    echo $e->getMessage() . "\n\n";
    echo "Piste de solution : Pour finaliser l'envoi d'e-mails réels depuis support@crediteco.app via SMTP, il convient de renseigner le serveur SMTP et le mot de passe dans le fichier .env (MAIL_HOST, MAIL_PORT, MAIL_PASSWORD).\n";
}
