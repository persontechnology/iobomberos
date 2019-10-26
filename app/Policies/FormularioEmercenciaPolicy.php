<?php

namespace iobom\Policies;

use iobom\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use iobom\Models\FormularioEmergencia;

class FormularioEmercenciaPolicy
{
    use HandlesAuthorization;
   
    public function comprobarAtensionHospitalaria( User $user,FormularioEmergencia $formularioEmergencia)
    {         
        if ($formularioEmergencia->emergencia->nombre=="ATENCION PREHOSPITALARIA") {
            return true;
        }
    }

    public function comprobarContraIncendio( User $user,FormularioEmergencia $formularioEmergencia)
    {         
        if ($formularioEmergencia->emergencia->nombre=="CONTRA INCENDIO") {
            return true;
        }
    }
}
