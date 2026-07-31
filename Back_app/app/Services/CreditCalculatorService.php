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

    public function scoreClient($application): int
    {
        $revenu = (float) ($application->revenu_net ?? 2500);
        $charges = (float) ($application->charges_mensuelles ?? 500);
        
        if ($revenu <= 0) {
            return 300;
        }

        $score = 550;

        // Taux d'endettement (max 400 pts)
        $ratio = ($charges / $revenu) * 100;
        if ($ratio < 15) {
            $score += 130;
        } elseif ($ratio < 25) {
            $score += 90;
        } elseif ($ratio < 35) {
            $score += 50;
        } elseif ($ratio < 45) {
            $score += 20;
        } else {
            $score -= 60;
        }

        // Reste à vivre
        $resteAVivre = $revenu - $charges;
        if ($resteAVivre >= 3000) {
            $score += 80;
        } elseif ($resteAVivre >= 2000) {
            $score += 50;
        } elseif ($resteAVivre >= 1000) {
            $score += 30;
        }

        // Situation professionnelle
        $situation = strtolower((string) ($application->situation_pro ?? ''));
        if (in_array($situation, ['cdi', 'fonctionnaire', 'salarie_cdi'], true)) {
            $score += 50;
        } elseif (in_array($situation, ['independant', 'retraite'], true)) {
            $score += 30;
        }

        // Hash déterministe pour stabiliser les petites variations selon l'ID
        $hashSeed = abs(crc32((string) ($application->email ?? $application->id))) % 30;
        $score += $hashSeed;

        return (int) min(850, max(300, $score));
    }
}
