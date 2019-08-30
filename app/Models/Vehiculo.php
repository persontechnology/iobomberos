<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\TipoVehiculo;
use iobom\Models\Estacion;

class Vehiculo extends Model
{
    protected $table="vehiculo";
	
   public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipoVehiculo_id');
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'estacion_id');
    }
}
