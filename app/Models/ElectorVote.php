<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectorVote extends Model
{
    use HasFactory;

    protected $table = "electors_votes";
}
