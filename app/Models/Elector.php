<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        "as_user",
    ];

    protected $hidden = [
        'secret_code',
        "pivot"
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    public function votes(): BelongsToMany
    {
        return $this->BelongsToMany(Vote::class, 'electors_votes', 'elector_id', 'vote_id')->with("candidats");
    }


    // public function vote($vote_id): HasOne
    // {
    //     return $this->hasOne(Vote::class, 'electors_votes', 'elector_id', 'vote_id')->where("vote_id", 1);
    // }
}
