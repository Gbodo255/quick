<?php

namespace App\Http\Controllers\Api;

use App\Services\DeepLTranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TranslationController extends Controller
{
    /**
     * Traduit un texte via DeepL API
     */
    public function translate(Request $request, DeepLTranslationService $translationService): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:50000',
            'targetLanguage' => 'required|string|in:en,de,es,fr',
        ]);

        $text = $validated['text'];
        $targetLanguage = DeepLTranslationService::getDeepLLanguageCode($validated['targetLanguage']);

        $translated = $translationService->translate($text, $targetLanguage);

        return response()->json([
            'translations' => [
                [
                    'text' => $translated,
                    'detected_source_language' => 'auto',
                ],
            ],
        ]);
    }

    /**
     * Traduit un objet JSON
     */
    public function translateObject(Request $request, DeepLTranslationService $translationService): JsonResponse
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'targetLanguage' => 'required|string|in:en,de,es,fr',
            'keysToTranslate' => 'nullable|array',
        ]);

        $targetLanguage = DeepLTranslationService::getDeepLLanguageCode($validated['targetLanguage']);

        $translated = $translationService->translateObject(
            $validated['data'],
            $targetLanguage,
            $validated['keysToTranslate'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $translated,
        ]);
    }

    /**
     * Récupère les statistiques d'utilisation de l'API DeepL
     */
    public function usage(DeepLTranslationService $translationService): JsonResponse
    {
        $usage = $translationService->getUsage();

        return response()->json($usage);
    }
}
