<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portrait extends Model
{
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function temoignages()
    {
        return $this->hasMany(Temoignage::class);
    }
}
