<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectorVote extends Model
{
    use HasFactory;

    protected $fillable = [
        "secret_code",
        "pivot"
    ];

    protected $table = "electors_votes";

}
