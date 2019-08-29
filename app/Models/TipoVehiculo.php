<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    protected $table="tipoVehiculo";
	
    protected $fillable = [
        'nombre', 'codigo','creadoPor','actualizadoPor',
    ];
}
