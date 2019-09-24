<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoReferencia extends Model
{
    protected $table = 'puntoReferencia';

    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }
}
