<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dossier\VerifyOtpRequest;
use App\Models\CreditApplication;
use App\Services\DossierService;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DossierOtpController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService,
        private readonly DossierService $dossierService,
    ) {}

    public function send(Request $request, string $reference): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $code = $this->otpService->send($application);

        return response()->json([
            'message' => 'Un code de vérification a été envoyé à votre adresse e-mail.',
        ]);
    }

    public function verify(VerifyOtpRequest $request, string $reference): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $this->otpService->verify($application, $request->validated('code'));

        $application = $this->dossierService->submit($application->fresh('documents'));

        return response()->json([
            'message' => 'Dossier soumis avec succès.',
            'dossier' => [
                'reference' => $application->reference,
                'status' => $application->status->value,
                'status_label' => $application->status->label(),
                'processing_step' => $application->processing_step,
                'submitted_at' => $application->submitted_at?->toIso8601String(),
            ],
        ]);
    }

    private function applicationFromRequest(Request $request): CreditApplication
    {
        return $request->attributes->get('credit_application');
    }
}
