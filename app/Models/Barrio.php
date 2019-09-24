<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $fillable = [
        'nombre', 'codigo','parroquia_id'
    ];

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'parroquia_id');
    }
}
