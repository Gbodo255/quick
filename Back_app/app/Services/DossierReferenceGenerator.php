<?php

namespace App\Services;

use App\Models\CreditApplication;

class DossierReferenceGenerator
{
    public function generate(): string
    {
        do {
            $reference = 'CR-'.strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        } while (CreditApplication::query()->where('reference', $reference)->exists());

        return $reference;
    }
}
