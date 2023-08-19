<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Action extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'visible'
    ];

    #MANY TO MANY RELATIONSHIP(UNE ACTION PEUT APPARTENIR A PLUISIEURS DROITS)
    function rights(): HasMany
    {
        return $this->hasMany(Right::class, 'action',);
    }
}
