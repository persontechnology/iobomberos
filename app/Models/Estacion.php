<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
	protected $table="estacion";
	
    protected $fillable = [
        'nombre', 'direccion', 'latitud','longitud','creadoPor','actualizadoPor',
    ];
}
