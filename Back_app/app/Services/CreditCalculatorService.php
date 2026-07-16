<?php

namespace App\Services;

class CreditCalculatorService
{
    public function mensualite(int $montant, int $dureeMois, ?float $tauxAnnuel = null): float
    {
        $tauxAnnuel ??= (float) config('credit.taux_annuel');
        $r = $tauxAnnuel / 100 / 12;
        $n = $dureeMois;

        if ($r <= 0) {
            return round($montant / $n, 2);
        }

        $mensualite = ($montant * $r * (1 + $r) ** $n) / ((1 + $r) ** $n - 1);

        return round($mensualite, 2);
    }

    public function totals(int $montant, int $dureeMois, float $mensualite): array
    {
        $totalRembourse = round($mensualite * $dureeMois, 2);
        $coutTotal = round($totalRembourse - $montant, 2);

        return [
            'total_rembourse' => $totalRembourse,
            'cout_total' => $coutTotal,
        ];
    }

    public function isEligible(float $revenuNet, float $chargesMensuelles): bool
    {
        if ($revenuNet <= 0) {
            return false;
        }

        $ratio = ($chargesMensuelles / $revenuNet) * 100;

        return $ratio < (float) config('credit.eligibility.max_charge_ratio_percent');
    }
}
