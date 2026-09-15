<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DossierController;
use App\Http\Controllers\Api\DossierDocumentController;
use App\Http\Controllers\Api\DossierOtpController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\SimulationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // Test route
    Route::get('test', fn () => response()->json(['status' => 'api_works']));

    Route::prefix('v1')->group(function (): void {
        Route::get('health', HealthController::class);
        Route::post('simulate', [SimulationController::class, 'simulate']);
        Route::post('contact', [ContactController::class, 'send'])
            ->middleware('throttle:5,1');

        Route::post('dossiers', [DossierController::class, 'store'])
            ->middleware('throttle:5,1');
        Route::get('dossiers/{reference}', [DossierController::class, 'show'])
            ->middleware('throttle:30,1');

        Route::middleware('dossier.token')->group(function (): void {
            Route::patch('dossiers/{reference}', [DossierController::class, 'update']);
            Route::post('dossiers/{reference}/documents/{type}', [DossierDocumentController::class, 'store'])
                ->whereIn('type', ['piece_identite', 'rib', 'certificat_scolarite']);
            Route::delete('dossiers/{reference}/documents/{type}', [DossierDocumentController::class, 'destroy'])
                ->whereIn('type', ['piece_identite', 'rib', 'certificat_scolarite']);
            Route::post('dossiers/{reference}/otp/send', [DossierOtpController::class, 'send'])
                ->middleware('throttle:3,1');
            Route::post('dossiers/{reference}/otp/verify', [DossierOtpController::class, 'verify'])
                ->middleware('throttle:5,1');
            Route::post('dossiers/{reference}/processing/tick', [DossierController::class, 'advanceProcessing']);
        });
    });
});
