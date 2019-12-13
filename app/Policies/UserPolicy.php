<?php

namespace iobom\Policies;

use iobom\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    

    // A:Deivid
    // D: un usuario puede crear un nuevo formulario de emergencia
    public function crearNuevoFormularioEmergencia(User $user)
    {
        if (count($user->asistenciaHoy)>0||$user->hasRole('Radio operador')) {
            return true;
        }
       
    }

    public function view(User $user, User $model)
    {
        //
    }

}
