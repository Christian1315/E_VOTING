<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        'username',
        'email',
        'password',
        'organisation',
        "phone",
        "pass_code",
        'rang_id',
        'profil_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    function my_admins(): HasMany
    {
        return $this->hasMany(Admin::class, "owner");
    }

    function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, "organisation")->where("is_super_admin", 0);
    }

    #ONE TO ONE/REVERSE RELATIONSHIP(UN UTILISATEUR NE PEUT QU'AVOIR UN SEUL RANG)
    function rang(): BelongsTo
    {
        return $this->belongsTo(Rang::class, 'rang_id');
    }

    #ONE TO MANY/INVERSE RELATIONSHIP (UN USER PEUT APPARTENIR A PLUISIEURS PROFILS)
    function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }

    function drts(): HasMany
    {
        return $this->hasMany(Right::class, "user_id");
    }
}
