<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectLanguageMiddleware
{
    /**
     * Détecte la langue basée sur le pays de l'utilisateur
     * Cette middleware définit la locale de Laravel basée sur l'IP
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer le pays via GeoIP (optionnel, si steelx/geoip est installé)
        // $country = geoip()->getLocation($request->ip())['iso_code'] ?? 'US';

        // Ou utiliser une API externe
        try {
            $response = \Http::withOptions(['timeout' => 2])->get('https://ipapi.co/json/');
            $country = $response->json('country_code', 'US');
        } catch (\Exception $e) {
            $country = 'US';
        }

        // Mapper pays → langue
        $languageMap = [
            'DE' => 'de',
            'AT' => 'de',
            'CH' => 'de',
            'ES' => 'es',
            'MX' => 'es',
            'AR' => 'es',
        ];

        $language = $languageMap[$country] ?? 'en';

        // Définir la locale Laravel
        app()->setLocale($language);

        return $next($request);
    }
}
