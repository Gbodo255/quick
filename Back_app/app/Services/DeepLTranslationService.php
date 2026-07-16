<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DeepLTranslationService
{
    private string $apiKey;

    private string $apiUrl;

    private int $cacheExpiry = 604800; // 7 jours en secondes

    public function __construct()
    {
        $this->apiKey = config('services.deepl.key');
        $this->apiUrl = config('services.deepl.url');
    }

    /**
     * Traduit un texte via DeepL
     *
     * @param  string  $text  Texte à traduire
     * @param  string  $targetLanguage  Langue cible (EN, DE, ES)
     * @return string Texte traduit
     */
    public function translate(string $text, string $targetLanguage): string
    {
        if (empty($text)) {
            return $text;
        }

        // Récupérer du cache si disponible
        $cacheKey = $this->getCacheKey($text, $targetLanguage);
        $cached = Cache::get($cacheKey);

        if ($cached !== null) {
            return $cached;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => "DeepL-Auth-Key {$this->apiKey}",
            ])->post("{$this->apiUrl}/translate", [
                'text' => $text,
                'target_lang' => $targetLanguage,
            ]);

            if ($response->failed()) {
                \Log::warning('DeepL translation failed', [
                    'status' => $response->status(),
                    'text' => $text,
                    'targetLanguage' => $targetLanguage,
                ]);

                return $text;
            }

            $translated = $response->json('translations.0.text');

            // Sauvegarder en cache
            Cache::put($cacheKey, $translated, $this->cacheExpiry);

            return $translated;
        } catch (\Exception $e) {
            \Log::error('DeepL API error', [
                'message' => $e->getMessage(),
                'text' => $text,
                'targetLanguage' => $targetLanguage,
            ]);

            return $text;
        }
    }

    /**
     * Traduit un tableau de textes
     *
     * @param  array  $texts  Textes à traduire
     * @param  string  $targetLanguage  Langue cible
     * @return array Textes traduits
     */
    public function translateArray(array $texts, string $targetLanguage): array
    {
        return array_map(
            fn ($text) => $this->translate($text, $targetLanguage),
            $texts
        );
    }

    /**
     * Traduit un objet JSON
     *
     * @param  array  $data  Données à traduire
     * @param  string  $targetLanguage  Langue cible
     * @param  array  $keysToTranslate  Clés à traduire (null = toutes)
     * @return array Données traduites
     */
    public function translateObject(array $data, string $targetLanguage, ?array $keysToTranslate = null): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            // Vérifier si cette clé doit être traduite
            if ($keysToTranslate !== null && ! in_array($key, $keysToTranslate)) {
                $result[$key] = $value;

                continue;
            }

            if (is_string($value)) {
                $result[$key] = $this->translate($value, $targetLanguage);
            } elseif (is_array($value)) {
                $result[$key] = $this->translateObject($value, $targetLanguage, $keysToTranslate);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Génère une clé de cache
     */
    private function getCacheKey(string $text, string $language): string
    {
        return 'deepl_'.md5($text.$language);
    }

    /**
     * Convertit le code de langue en format DeepL
     */
    public static function getDeepLLanguageCode(string $language): string
    {
        $map = [
            'en' => 'EN',
            'de' => 'DE',
            'es' => 'ES',
            'fr' => 'FR',
        ];

        return $map[strtolower($language)] ?? 'EN';
    }

    /**
     * Récupère l'utilisation de l'API
     */
    public function getUsage(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "DeepL-Auth-Key {$this->apiKey}",
            ])->get("{$this->apiUrl}/usage");

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('Failed to get DeepL usage', ['message' => $e->getMessage()]);

            return [];
        }
    }
}
