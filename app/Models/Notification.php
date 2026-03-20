<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = ['visa_id', 'type_alerte', 'statut_envoi', 'date_envoi', 'message'];

    // La notification appartient à un visa spécifique
    public function visa(): BelongsTo
    {
        return $this->belongsTo(Visa::class);
    }
}