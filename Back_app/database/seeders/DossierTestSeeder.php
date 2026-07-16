<?php

namespace Database\Seeders;

use App\Models\CreditApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DossierTestSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            'submitted',
            'processing',
            'approved',
            'completed',
            'draft'
        ];

        $prenoms = ['Jean', 'Marie', 'Paul', 'Sophie', 'Luc'];
        $noms = ['Dupont', 'Martin', 'Durand', 'Bernard', 'Petit'];

        foreach ($statuses as $index => $status) {
            CreditApplication::create([
                'reference' => 'TEST-' . strtoupper(Str::random(8)),
                'access_token' => Str::uuid()->toString(),
                'status' => $status,
                'processing_step' => ($status === 'processing') ? 2 : (($status === 'completed') ? 4 : 0),
                'montant' => rand(5000, 50000),
                'duree_mois' => 60,
                'taux_annuel' => 2.5,
                'mensualite' => rand(100, 900),
                'prenom' => $prenoms[$index],
                'nom' => $noms[$index],
                'email' => strtolower($prenoms[$index] . '.' . $noms[$index] . '@example.com'),
                'telephone' => '06' . rand(10000000, 99999999),
                'is_eligible' => true,
                'consent_1' => true,
                'consent_2' => true,
                'consent_3' => true,
                'otp_verified_at' => now(),
                'submitted_at' => ($status === 'draft') ? null : now()->subDays(rand(1, 10)),
                'is_archived' => false,
                'created_at' => now()->subDays(rand(1, 15)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
        }
    }
}
