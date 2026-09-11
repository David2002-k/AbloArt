<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temoignage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'message',
        'publie',
        'portrait_id',
    ];

    public function portrait()
    {
        return $this->belongsTo(Portrait::class);
    }
}
