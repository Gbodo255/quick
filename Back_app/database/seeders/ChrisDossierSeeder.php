<?php

namespace Database\Seeders;

use App\Models\CreditApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChrisDossierSeeder extends Seeder
{
    public function run()
    {
        CreditApplication::create([
            'reference' => 'DOS-' . strtoupper(Str::random(6)),
            'access_token' => Str::uuid()->toString(),
            'status' => 'submitted', // Soumis par défaut pour qu'il soit visible dans les "À traiter"
            'processing_step' => 4,
            'montant' => 20000,
            'duree_mois' => 60,
            'taux_annuel' => 2.9,
            'mensualite' => 358.49,
            'prenom' => 'Chris',
            'nom' => 'Vianney',
            'email' => 'chrisvianneymaoule@gmail.com',
            'telephone' => '0612345678',
            'is_eligible' => true,
            'consent_1' => true,
            'consent_2' => true,
            'consent_3' => true,
            'otp_verified_at' => now(),
            'submitted_at' => now(),
            'is_archived' => false,
        ]);
    }
}
