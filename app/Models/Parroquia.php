<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    protected $fillable = [
        'nombre', 'codigo',
    ];

    public function barrios()
    {
        return $this->hasMany(Barrio::class,'parroquia_id');
    }
}
