<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portrait extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'categorie_id',
        'admin_id',
        'description',
        'image',
        'video',
        'date_realisation',
    ];

    protected $casts = [
        'date_realisation' => 'date',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
