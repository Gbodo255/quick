<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DiditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DossierLivenessController extends Controller
{
    public function __construct(private readonly DiditService $didit) {}

    public function store(Request $request, string $reference): JsonResponse
    {
        return response()->json($this->didit->createSession($request->attributes->get('credit_application')));
    }

    public function status(Request $request, string $reference): JsonResponse
    {
        return response()->json($this->didit->status($request->attributes->get('credit_application')));
    }
}
