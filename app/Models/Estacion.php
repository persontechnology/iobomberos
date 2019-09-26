<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;
use iobom\User;

class Estacion extends Model
{
	protected $table="estacion";
	
    protected $fillable = [
        'nombre', 'direccion', 'latitud','longitud','creadoPor','actualizadoPor',
    ];


    
    public function personales()
    {
        return $this->hasMany(User::class);
    }


    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

}
