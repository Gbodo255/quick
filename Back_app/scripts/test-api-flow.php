<?php

$base = 'http://127.0.0.1:8000/api/v1';

function request(string $method, string $url, ?array $json = null, ?string $token = null): array
{
    $ch = curl_init($url);
    $headers = ['Accept: application/json'];
    if ($json !== null) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
    }
    if ($token) {
        $headers[] = 'X-Dossier-Token: '.$token;
    }
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['code' => $code, 'body' => json_decode($body, true) ?? $body];
}

$create = request('POST', "$base/dossiers", [
    'montant' => 25000,
    'duree_mois' => 48,
    'motif' => 'travaux',
]);
echo "CREATE {$create['code']}\n";
if ($create['code'] !== 201) {
    print_r($create);
    exit(1);
}

$ref = $create['body']['dossier']['reference'];
$token = $create['body']['token'];

$steps = [
    ['prequal', ['situation_pro' => 'cdi', 'situation_logement' => 'locataire', 'revenu_net' => 3500, 'charges_mensuelles' => 500]],
    ['identite', ['civilite' => 'M.', 'prenom' => 'User', 'nom' => 'Test', 'email' => 'user@company.local', 'telephone' => '0000000000', 'date_naissance' => '2000-01-01', 'adresse' => 'Street', 'code_postal' => '00000', 'ville' => 'City']],
    ['situation', ['employeur' => 'ACME', 'anciennete' => '1a3ans', 'situation_pro' => 'cdi']],
    ['projet', ['motif' => 'travaux']],
    ['documents', ['piece_identite_type' => 'cni']],
    ['recap', ['consent_1' => true, 'consent_2' => true, 'consent_3' => true]],
];

foreach ($steps as [$step, $payload]) {
    $r = request('PATCH', "$base/dossiers/$ref", array_merge(['step' => $step], $payload), $token);
    echo "PATCH $step => {$r['code']}\n";
    if ($r['code'] !== 200) {
        print_r($r);
        exit(1);
    }
}

$otpSend = request('POST', "$base/dossiers/$ref/otp/send", null, $token);
echo "OTP SEND {$otpSend['code']}\n";

echo "Check storage/logs/laravel.log for OTP code\n";
echo "DONE (upload + verify skipped in CLI test)\n";
