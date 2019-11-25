<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;
use iobom\User;

class Asistencia extends Model
{
    
    
    // una aistencia tiene varios personales registrados
    public function asistenciaPersonal()
    {
        return $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')->withPivot(['id','estado','estadoEmergencia','observacion']);
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
     // una aistencia tiene varios vehiculos registrados en esatdo activo
     public function asistenciaVehiculoActivos()
     {
         return $this->belongsToMany(Vehiculo::class, 'asistencia_vehiculos', 'asistencia_id', 'vehiculo_id')
         
         ->as('asistenciaVehiculo')
         ->withPivot(['id','estado','observacion']);
     }
     // una aistencia tiene varios vehiculos registrados en esatdo activo
     public function asistenciasAsistenciaVehiculo()
     {
        return $this->hasMany(AsistenciaVehiculo::class,'asistencia_id');
     }
     public function asistenciasAsistenciaPersonal($id)
     {
       return  $users = DB::table('users')
            ->where('asistencia_personals.asistencia_id',$id)
            ->join('asistencia_personals', 'users.id', '=', 'asistencia_personals.user_id')            
            ->select('users.name as nombreUser','asistencia_personals.id as idAsistencia')
            ->get();
     }
       // una aistencia tiene varios personales registrados
    public function asietenciaAsistenciaPersonalesAscendente()
    {
        return $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')
        ->withPivot(['id','estado','estadoEmergencia','observacion'])
        ->wherePivot('estado',true)
        ->wherePivot('estadoEmergencia','Disponible')
        ->orderBy('name','asc')
        ;
    }

    public function asietenciaAsistenciaPersonalesDescendente()
    {
        return $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')
        ->withPivot(['id','estado','estadoEmergencia','observacion'])
        ->wherePivot('estado',true)
        ->wherePivot('estadoEmergencia','Disponible')
        ->orderBy('name','desc')
        ;
    }

    public function asietenciaAsistenciaPersonalesEncargado()
    {
        $usuarios= $this->belongsToMany(User::class, 'asistencia_personals', 'asistencia_id', 'user_id')
        ->as('asistenciaPersonal')
        ->withPivot(['id','estado','estadoEmergencia','observacion'])
        ->wherePivot('estado',true)
        ->wherePivot('estadoEmergencia','Disponible')
        ->orderBy('name','asc')
        ;
        return $listado=$usuarios->whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');

        });
    }
     
}
