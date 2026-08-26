<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{   
    protected $fillable = [
        'user_id',
        'biographie',
        'photo',
        'telephone',
        'adresse',
        'cv',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function portraits(){
        return $this->hasMany(Portrait::class);
    }

}
