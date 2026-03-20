<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visa extends Model
{
    protected $fillable = [
        'country_id', 'nom_etranger', 'numero_passeport', 
        'type_visa', 'date_entree', 'date_expiration', 
        'email_contact', 'telephone_contact', 'statut'
    ];

    // Le visa appartient à un pays
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Le visa peut avoir plusieurs notifications envoyées
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}