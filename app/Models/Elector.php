<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Elector extends Model
{
    use HasFactory;

    protected $fillable =  [
        "name",
        "identifiant",
        "phone",
        "email",
        "secret_code",
        "owner",
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }
}
