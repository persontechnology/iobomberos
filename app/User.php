<?php

namespace iobom;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Asistencia\AsistenciaPersonal;
use Spatie\Permission\Traits\HasRoles;
use iobom\Models\Estacion;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //A:Deivid
    // D: retornar usuarios creado y actualizado por
    public function creadoPor($idUsuario)
    {
        $user=$this::find($idUsuario);
        if($user){
            return $user;
        }
        return '';
    }

    public function actualizadoPor($idUsuario)
    {
        $user=$this::find($idUsuario);
        if($user){
            return $user;
        }
        return '';
    }
    public function estacion()
    {
         return $this->belongsTo(Estacion::class, 'estacion_id');
    }
    

    // A:Deivid
    // D:u usuario puede crear un nuevo formulario de emergecnia, siempre cuando, el uaurio este el registro de asistencia del dia de hoy,
    // y la asietncia se encuentre en un estado activo.
    // crear nuevo formulario de emergencia, 
    // cuando el usuario esta registrado en la asitencia, en un estado activo
    // pertenesca a la estacion 
    // el usuario esta en estado activo
    // y la asitencia es igual a la fecha actual

    public function asistenciaHoy()
    {
        $diaHoy=Carbon::now()->addDays(1);
        $fechaMenor=$diaHoy->setDateTime($diaHoy->year,$diaHoy->month,$diaHoy->day,7,30,0,0)->toDateTimeString();
        return $this->belongsToMany(Asistencia::class, 'asistencia_personals', 'user_id', 'asistencia_id')
        ->withPivot(['id','estado'])
        ->wherePivot('estado',true)
        ->where('fecha',Carbon::now()->toDateString())->where('fechaFin','<=',$fechaMenor);
    }

}
