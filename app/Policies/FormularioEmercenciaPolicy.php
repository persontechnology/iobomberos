<?php

namespace iobom\Policies;

use iobom\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;

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
    public function cambioEstadoProceso(User $user,FormularioEmergencia $formularioEmergencia)
    {
        if ($formularioEmergencia->estado=="Asignado"&&$user->hasAnyRole('Radio operador','Operativos','Clase de guardía','Oficial de guardía')) {
            return true;
        }else{
            return false;
        }
    }
    public function misFormularios(User $user,FormularioEmergencia $formularioEmergencia)
    {
        $asistencias=AsistenciaPersonal::where('user_id',$user->id)->get();       
   
        $formularioEmergencia=FormularioEmergencia::where('id',$formularioEmergencia->id)
        ->where('estado',"Proceso")
        ->whereIn('encardadoFicha_id',$asistencias->pluck('id'))
        ->get();
        if($formularioEmergencia->count()>0){
            return true;
        }else{
            return false;
        }
    }
}
