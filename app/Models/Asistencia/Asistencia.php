<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;
use iobom\User;

class Asistencia extends Model
{
    
    
    // una aistencia tiene varios personales registrados
    public function asistenciaPersonal()
    {
        return $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')->withPivot(['id','estado','observacion']);
    }


    // una aistencia tiene varios vehiculos registrados
    public function asistenciaVehiculo()
    {
        return $this->belongsToMany(Vehiculo::class, 'asistencia_vehiculos', 'asistencia_id', 'vehiculo_id')
        ->as('asistenciaVehiculo')->withPivot(['id','estado','observacion']);;
    }


    // asitencia generada en un estacion, de acuerdo donde se enbcuentra el usuario
    public function estacion()
    {
         return $this->belongsTo(Estacion::class, 'estacion_id');
    }


    // usuario quien crea la asistencia
    public function user()
    {
         return $this->belongsTo(User::class, 'user_id');
    }
}
