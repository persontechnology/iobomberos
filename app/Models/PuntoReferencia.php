<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoReferencia extends Model
{
    protected $table = 'puntoReferencia';
    protected $fillable = [
        'latitud', 'longitud', 'referencia','barrio_id','creadoPor','actualizadoPor',
    ];
    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }
}
