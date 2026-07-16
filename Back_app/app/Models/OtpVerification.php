<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpVerification extends Model
{
    protected $fillable = [
        'credit_application_id',
        'code_hash',
        'attempts',
        'expires_at',
        'sent_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'attempts' => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CreditApplication::class, 'credit_application_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
