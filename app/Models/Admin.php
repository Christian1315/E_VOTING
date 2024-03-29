<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "organisation",
        "username"
    ];

    function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner")->where("is_super_admin", 0);
    }

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, "organisation");
    }
}
