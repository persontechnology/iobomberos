<?php

namespace iobom\Policies;

use iobom\User;
use iobom\Models\Asistencia\Asistencia;
use Illuminate\Auth\Access\HandlesAuthorization;

class AsistenciaPolicy
{
    use HandlesAuthorization;
    
   

    public function view(User $user, Asistencia $asistencia)
    {
        //
    }
}
