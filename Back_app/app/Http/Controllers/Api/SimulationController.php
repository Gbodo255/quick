<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dossier\SimulateCreditRequest;
use App\Services\CreditCalculatorService;
use Illuminate\Http\JsonResponse;

class SimulationController extends Controller
{
    public function __construct(
        private readonly CreditCalculatorService $calculator,
    ) {}

    public function simulate(SimulateCreditRequest $request): JsonResponse
    {
        $montant = (int) $request->validated('montant');
        $duree = (int) $request->validated('duree_mois');
        $mensualite = $this->calculator->mensualite($montant, $duree);
        $totals = $this->calculator->totals($montant, $duree, $mensualite);

        return response()->json([
            'montant' => $montant,
            'duree_mois' => $duree,
            'taux_annuel' => (float) config('credit.taux_annuel'),
            'mensualite' => $mensualite,
            'cout_total' => $totals['cout_total'],
            'total_rembourse' => $totals['total_rembourse'],
        ]);
    }
}
