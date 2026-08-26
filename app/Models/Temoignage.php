<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    public function portrait()
    {
        return $this->belongsTo(Portrait::class);
    }
}
