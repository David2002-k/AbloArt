<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandePortrait extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'description',
        'photo_reference',
        'statut',
        'commentaire_admin',
    ];
}
