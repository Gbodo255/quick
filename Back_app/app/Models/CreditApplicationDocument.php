<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditApplicationDocument extends Model
{
    protected $fillable = [
        'credit_application_id',
        'type',
        'disk',
        'path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'status',
    ];

    protected $casts = [
        'type' => DocumentType::class,
        'size_bytes' => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'credit_application_id');
    }
}
