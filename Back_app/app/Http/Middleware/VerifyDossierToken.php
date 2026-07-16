<?php

namespace App\Http\Middleware;

use App\Models\CreditApplication;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class VerifyDossierToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $reference = $request->route('reference');
        $token = $request->header('X-Dossier-Token');

        if (! $reference || ! $token) {
            throw new UnauthorizedHttpException('', 'Jeton de dossier manquant ou invalide.');
        }

        $application = CreditApplication::query()
            ->where('reference', $reference)
            ->first();

        if (! $application || ! hash_equals($application->access_token, $token)) {
            throw new NotFoundHttpException('Dossier introuvable.');
        }

        $request->attributes->set('credit_application', $application);

        return $next($request);
    }
}
