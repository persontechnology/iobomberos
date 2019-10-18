<?php

namespace iobom\Policies;

use Carbon\Carbon;
use iobom\User;
use iobom\Models\Estacion;
use Illuminate\Auth\Access\HandlesAuthorization;
use iobom\Models\Asistencia\Asistencia;

class EstacionPolicy
{
    use HandlesAuthorization;
    
    
    public function actualizar(User $user, Estacion $estacion)
    {
        //
    }

    public function generarAsistencia(User $user,Estacion $estacion)
    {
        if($user->can('Generar asistencia') && $user->hasRole('Clase de guardía') && $user->estacion->id==$estacion->id ){
            return true;
        }

        if($user->can('Generar asistencia') && $user->hasRole('Oficial de guardía')){
            return true;
        }

    }


}
