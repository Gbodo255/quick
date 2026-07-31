<?php

return [

    'brand' => env('CREDIT_BRAND', 'Quickcredit'),

    'taux_annuel' => (float) env('CREDIT_TAUX_ANNUEL', 3.9),

    'frais_dossier' => (float) env('CREDIT_FRAIS_DOSSIER', 250),

    'montant_min' => (int) env('CREDIT_MONTANT_MIN', 1000),

    'montant_max' => (int) env('CREDIT_MONTANT_MAX', 75000),

    'durees_mois' => [12, 24, 36, 48, 60, 84],

    'otp' => [
        'length' => 6,
        'expires_minutes' => (int) env('OTP_EXPIRES_MINUTES', 10),
        'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),
        'resend_cooldown_seconds' => (int) env('OTP_RESEND_COOLDOWN', 60),
    ],

    'documents' => [
        'max_size_kb' => 10240,
        'mimes' => ['pdf', 'jpg', 'jpeg', 'png'],
    ],

    'eligibility' => [
        'max_charge_ratio_percent' => 45,
    ],

];
