<?php

use App\Http\Middleware\VerifyDossierToken;
use App\Http\Middleware\SecurityHeadersMiddleware;
use App\Support\ApiMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            HandleCors::class,
            SecurityHeadersMiddleware::class,
        ]);

        $middleware->web(prepend: [
            SecurityHeadersMiddleware::class,
        ]);

        // Exclure les routes API de la vérification CSRF
        $middleware->preventRequestForgery([
            'api/*',
            'sanctum/csrf-cookie',
        ]);

        $middleware->alias([
            'dossier.token' => VerifyDossierToken::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn (Request $request) => $request->is('api/*') || $request->expectsJson());

        $exceptions->render(function (ValidationException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => 'Les données fournies sont invalides.',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => 'Ressource introuvable.',
            ], 404);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => $e->getMessage() ?: 'Accès refusé.',
            ], 403);
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json([
                'message' => ApiMessage::sanitize($e->getMessage()),
            ], $e->getStatusCode());
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            report($e);

            return response()->json([
                'message' => 'Connexion à la base de données impossible. Vérifiez PostgreSQL et le fichier .env (DB_PASSWORD).',
            ], 503);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            if ($e instanceof ValidationException
                || $e instanceof ModelNotFoundException
                || $e instanceof NotFoundHttpException
                || $e instanceof HttpException
                || $e instanceof AuthorizationException
                || $e instanceof QueryException) {
                return null;
            }

            report($e);

            $message = config('app.debug')
                ? ApiMessage::sanitize($e->getMessage())
                : 'Une erreur serveur est survenue.';

            return response()->json(['message' => $message], 500);
        });
    })->create();
