<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "img",
        "description",
        "organisation"
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function belong_to_organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, "organisation");
    }

    public function votes(): BelongsToMany
    {
        return $this->BelongsToMany(Vote::class, 'candidats_votes', 'candidat_id', 'vote_id')->withPivot("score");
    }
}
