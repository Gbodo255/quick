<?php

namespace App\Http\Controllers\Api;

use App\Enums\DocumentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dossier\UploadDocumentRequest;
use App\Http\Resources\DossierResource;
use App\Models\CreditApplication;
use App\Services\DocumentStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class DossierDocumentController extends Controller
{
    public function __construct(
        private readonly DocumentStorageService $storage,
    ) {}

    public function store(UploadDocumentRequest $request, string $reference, string $type): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $documentType = $this->resolveType($type);

        $this->storage->store($application, $documentType, $request->file('file'));

        return response()->json(new DossierResource($application->fresh('documents')));
    }

    public function destroy(Request $request, string $reference, string $type): JsonResponse
    {
        $application = $this->applicationFromRequest($request);
        $this->storage->delete($application, $this->resolveType($type));

        return response()->json(new DossierResource($application->fresh('documents')));
    }

    private function resolveType(string $type): DocumentType
    {
        return DocumentType::tryFrom($type)
            ?? throw new InvalidArgumentException('Type de document invalide.');
    }

    private function applicationFromRequest(Request $request): CreditApplication
    {
        return $request->attributes->get('credit_application');
    }
}
