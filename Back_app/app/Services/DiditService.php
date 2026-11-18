<?php

namespace App\Services;

use App\Models\CreditApplication;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Liveness via Didit (https://docs.didit.me). Le navigateur passe la vérification sur la page hébergée
 * par Didit (iframe) ; le backend crée la session puis relit la décision côté serveur.
 */
class DiditService
{
    /** Statuts Didit qui ne changeront plus : inutile de rappeler l'API. */
    private const FINAL = ['Approved', 'Declined', 'Expired', 'Kyc Expired'];

    public function isConfigured(): bool
    {
        return filled(config('services.didit.api_key')) && filled(config('services.didit.workflow_id'));
    }

    /** Crée (ou reprend, Didit dédoublonne par vendor_data) une session et renvoie son URL hébergée. */
    public function createSession(CreditApplication $application): array
    {
        $response = $this->send(fn (PendingRequest $r) => $r->post('/v3/session/', [
            'workflow_id' => config('services.didit.workflow_id'),
            'vendor_data' => $application->reference,
            'language' => 'fr',
        ]));

        $application->update([
            'liveness_session_id' => $response->json('session_id'),
            'liveness_status' => $response->json('status'),
        ]);

        return ['url' => $response->json('url')];
    }

    /** Statut : not_started | pending | passed | failed (+ statut Didit brut). */
    public function status(CreditApplication $application): array
    {
        if ($application->liveness_session_id && ! in_array($application->liveness_status, self::FINAL, true)) {
            $status = $this->send(fn (PendingRequest $r) => $r->get("/v3/session/{$application->liveness_session_id}/decision/"))
                ->json('status');
            $application->update(['liveness_status' => $status, 'liveness_checked_at' => now()]);
        }

        $raw = $application->liveness_status;

        return [
            'status' => match (true) {
                $raw === null, $raw === 'Not Started' => 'not_started',
                $raw === 'Approved' => 'passed',
                in_array($raw, ['Declined', 'Expired', 'Abandoned', 'Kyc Expired'], true) => 'failed',
                default => 'pending', // In Progress, In Review, Resubmitted…
            },
            'didit_status' => $raw,
        ];
    }

    /** @param callable(PendingRequest): Response $call */
    private function send(callable $call): Response
    {
        if (! $this->isConfigured()) {
            throw new ServiceUnavailableHttpException(null, 'La vérification faciale n\'est pas configurée.');
        }

        try {
            $response = $call(Http::baseUrl(rtrim(config('services.didit.base_url'), '/'))
                ->acceptJson()
                ->timeout(15)
                ->withHeaders(['x-api-key' => config('services.didit.api_key')]));
        } catch (ConnectionException) {
            throw new ServiceUnavailableHttpException(null, 'Le service de vérification faciale est injoignable.');
        }

        if ($response->failed()) {
            report(new \RuntimeException('Didit '.$response->status().': '.$response->body()));
            throw new ServiceUnavailableHttpException(null, 'La vérification faciale est indisponible pour le moment.');
        }

        return $response;
    }
}
