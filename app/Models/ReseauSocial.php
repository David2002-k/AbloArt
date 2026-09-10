<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReseauSocial extends Model
{
    protected $fillable = [
        'nom',
        'url',
        'icone',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
