<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;
use iobom\User;

class Asistencia extends Model
{
    public function asistenciaPersonal()
    {
        return $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')->withPivot(['id','estado','observacion']);
    }

    public function asistenciaVehiculo()
    {
        return $this->belongsToMany(Vehiculo::class, 'asistencia_vehiculos', 'asistencia_id', 'vehiculo_id')
        ->as('asistenciaVehiculo')->withPivot(['id','estado','observacion']);;
    }

    public function estacion()
    {
         return $this->belongsTo(Estacion::class, 'estacion_id');
    }

    public function user()
    {
         return $this->belongsTo(User::class, 'user_id');
    }
}
