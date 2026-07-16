<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'user_id', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
