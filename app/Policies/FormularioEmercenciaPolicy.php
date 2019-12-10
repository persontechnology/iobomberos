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
    public function noPreospitalario( User $user,FormularioEmergencia $formularioEmergencia)
    {
            return true;
    }
    public function editarFormulario(User $user,FormularioEmergencia $formularioEmergencia)
    {
        if($user->id == $formularioEmergencia->creadoPor || $user->hasRole('Radio operador')){
            if($formularioEmergencia->estado=="Asignado"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
