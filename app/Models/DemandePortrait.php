<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandePortrait extends Model
{
    use SoftDeletes;

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
