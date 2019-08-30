<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Vehiculo;
class TipoVehiculo extends Model
{
    protected $table="tipoVehiculo";
	
    protected $fillable = [
        'nombre', 'codigo','creadoPor','actualizadoPor',
    ];
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class,'tipoVehiculo_id');
    }
    
}
