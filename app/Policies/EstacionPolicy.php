<?php

namespace iobom\Policies;

use iobom\User;
use iobom\Models\Estacion;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstacionPolicy
{
    use HandlesAuthorization;
    
    
    public function actualizar(User $user, Estacion $estacion)
    {
        //
    }
}
