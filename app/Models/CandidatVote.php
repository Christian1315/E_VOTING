<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatVote extends Model
{
    use HasFactory;

    protected $table = "candidats_votes";
}
