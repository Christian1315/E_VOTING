<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rang extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    #ONE TO MANY RELATIONSHIP(UN RANG PEUT ETRE ASSOCIER A PLUSIEURS UTILISATEURS)
    function users(): HasMany
    {
        return $this->hasMany(User::class, 'rang_id');
    }

    #MANY TO MANY RELATIONSHIP(UN RANG PEUT APPARTENIR A PLUSIEURS DROITS)
    function rights(): BelongsToMany
    {
        return $this->belongsToMany(Right::class, 'rangs_rights', "rang_id", "right_id");
    }
}
