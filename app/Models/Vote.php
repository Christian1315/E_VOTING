<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "organisation",
        "status",
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    public function candidats(): BelongsToMany
    {
        return $this->BelongsToMany(Candidat::class, 'candidats_votes', 'vote_id', 'candidat_id');
    }

    public function electors(): BelongsToMany
    {
        return $this->BelongsToMany(Elector::class, 'electors_votes', 'vote_id', 'elector_id');
    }
}