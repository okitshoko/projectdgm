<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['nom_pays', 'code_iso'];

    // Un pays a plusieurs visas
    public function visas(): HasMany
    {
        return $this->hasMany(Visa::class);
    }
}