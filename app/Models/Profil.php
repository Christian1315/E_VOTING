<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profil extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    #ONE TO MANY/INVERSE RELATIONSHIP(UN USER PEUT AVOIR PLUISIEURS PROFILS)
    function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    #MANY TO MANY RELATIONSHIP(UN PROFIL PEUT AVOIR  PLUSIEURS DROITS)
    function rights(): BelongsToMany
    {
        return $this->belongsToMany(Right::class, 'profils_rights', "profil_id", "right_id");
    }
}
