<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            $db = true;
        } catch (\Throwable) {
            $db = false;
        }

        return response()->json([
            'status' => $db ? 'ok' : 'degraded',
            'api' => true,
            'database' => $db,
        ], $db ? 200 : 503);
    }
}
