<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];
}
