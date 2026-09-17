<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dossier\CreateDossierRequest;
use App\Http\Requests\Dossier\UpdateDossierRequest;
use App\Http\Resources\DossierResource;
use App\Models\CreditApplication;
use App\Services\DossierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    public function __construct(
        private readonly DossierService $dossierService,
    ) {}

    public function store(CreateDossierRequest $request): JsonResponse
    {
        if ($request->has('email')) {
            $status = \App\Models\ClientStatus::where('email', $request->email)->first();
            if ($status && $status->is_blocked) {
                return response()->json(['message' => 'Action non autorisée.'], 403);
            }
        }

        $application = $this->dossierService->create($request->validated());

        return response()->json([
            'message' => 'Dossier initialisé.',
            'token' => $application->access_token,
            'dossier' => new DossierResource($application),
        ], 201);
    }

    public function show(string $reference): JsonResponse
    {
        $application = CreditApplication::query()
            ->with(['documents'])
            ->where('reference', $reference)
            ->firstOrFail();

        return response()->json(new DossierResource($application));
    }

    public function update(UpdateDossierRequest $request, string $reference): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $application = $this->dossierService->updateStep(
            $application,
            $request->step(),
            $request->stepPayload(),
        );

        return response()->json(new DossierResource($application));
    }

    public function advanceProcessing(Request $request, string $reference): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $application = $this->dossierService->advanceProcessing($application);

        return response()->json(new DossierResource($application));
    }

    private function applicationFromRequest(Request $request): CreditApplication
    {
        return $request->attributes->get('credit_application');
    }
}
