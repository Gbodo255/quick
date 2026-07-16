<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierNote extends Model
{
    use HasFactory;

    protected $fillable = ['credit_application_id', 'user_id', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
