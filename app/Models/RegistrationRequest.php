<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'statut',
        'motif_rejet',
    ];

    protected $hidden = ['password'];
}