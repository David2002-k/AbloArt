<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReseauSocial extends Model
{
    use SoftDeletes;

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
