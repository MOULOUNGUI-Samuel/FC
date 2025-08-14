<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use
        // HasApiTokens,
        HasFactory,
        Notifiable,
        HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_utilisateur',
        'prenom',
        'nom',
        'nom_utilisateur',
        'profession',
        'date_naissance',
        'genre',
        'email',
        'numero_telephone',
        'numero_telephone_secondaire',
        'pays',
        'ville',
        'adresse',
        'numero_carte_identite',
        'numero_ifu',
        'numero_rccm',
        'password',
        'google_id',
        'est_actif',
        'role_id',
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
        'email_verifie_le' => 'datetime',
        'password' => 'hashed',
        'date_naissance' => 'date',
        'est_actif' => 'boolean',
    ];


    /**
     * Get the user's role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
