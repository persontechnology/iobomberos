<?php

namespace iobom;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
}
