<?php

namespace App\Services;

use App\Enums\DocumentType;
use App\Models\CreditApplication;
use App\Models\CreditApplicationDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class DocumentStorageService
{
    public function store(CreditApplication $application, DocumentType $type, UploadedFile $file): CreditApplicationDocument
    {
        if (! $application->isEditable()) {
            throw new ConflictHttpException('Ce dossier ne peut plus être modifié.');
        }

        $directory = "dossiers/{$application->reference}";
        $filename = $type->value.'_'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'local');

        $existing = $application->documents()->where('type', $type->value)->first();
        if ($existing) {
            Storage::disk($existing->disk)->delete($existing->path);
            $existing->delete();
        }

        return $application->documents()->create([
            'type' => $type->value,
            'disk' => 'local',
            'path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
            'size_bytes' => $file->getSize(),
            'status' => 'received',
        ]);
    }

    public function delete(CreditApplication $application, DocumentType $type): void
    {
        if (! $application->isEditable()) {
            throw new ConflictHttpException('Ce dossier ne peut plus être modifié.');
        }

        $document = $application->documents()->where('type', $type->value)->first();

        if (! $document) {
            return;
        }

        Storage::disk($document->disk)->delete($document->path);
        $document->delete();
    }
}
