<?php

namespace iobom\Policies;

use iobom\User;
use iobom\Models\Emergencia\Emergencia;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmergenciaPolicy
{
    use HandlesAuthorization;
 
    public function accesso(User $user)
    {
        if($user->can('G. de emergencia')){
            return true;
        }
    }

    public function view(User $user, Emergencia $emergencia)
    {
        //
    }

}
