<?php

namespace iobom\Policies;

use iobom\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\FormularioEmergencia\VehiculoParamedico;

class FormularioEmercenciaPolicy
{
    use HandlesAuthorization;
   
    public function comprobarAtensionHospitalaria( User $user,FormularioEmergencia $formularioEmergencia)
    {         
        if ($formularioEmergencia->emergencia->nombre=="ATENCION PREHOSPITALARIA" ) {
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
            if($formularioEmergencia->estado!="Finalizado"){
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
        if ($formularioEmergencia->estado=="Asignado"  && $user->hasAnyRole(['Radio operador','Operativos','Clase de guardía','Oficial de guardía'])) {
            return true;
        }else{
            return false;
        }
    }
    public function misFormularios(User $user,FormularioEmergencia $formularioEmergencia)
    {
        $asistencias=AsistenciaPersonal::where('user_id',$user->id)->get();       
   
        $formularioEmergenciaTotal=FormularioEmergencia::where('id',$formularioEmergencia->id)
        ->where('estado',"Proceso")
        ->whereIn('encardadoFicha_id',$asistencias->pluck('id'))
        ->get();
        if($formularioEmergenciaTotal->count()>0){
            return true;
        }else{
            if($formularioEmergencia->estado=="Finalizado" && $user->hasAnyRole(['Jefe de operaciones'])){
                return true;
            }else{
                return false;
            }
        }
    }
    public function formularioFinalizadoPAramedico(User $user,FormularioEmergencia $formularioEmergencia)
    {
        $asistencias=AsistenciaPersonal::where('user_id',$user->id)->get(); 
        $vehiculos= $formularioEmergencia->formularioVehiculos;
        $vistaParamedico=VehiculoParamedico::whereIn('estacionForVehiculo_id',$vehiculos->pluck('id'))->get();
        $verTotal=$vistaParamedico->whereIn('asistenciaPersonal_id',$asistencias->pluck('id'))->count();
        if($formularioEmergencia->estado=="Finalizado" && $user->hasAnyRole(['Jefe de operaciones'])){
        return true;
        }else{
            if($formularioEmergencia->estado=="Proceso" && $formularioEmergencia->heridos>0){
                if($verTotal>0){
                    return true;
                }
            }else{
                if($formularioEmergencia->estado=="Proceso" && $formularioEmergencia->emergencia->nombre=="ATENCION PREHOSPITALARIA"){
                    if($verTotal>0){
                        return true;
                    }
                }
            }
        }
        
    }
    public function imprimirFormulario(User $user,FormularioEmergencia $formularioEmergencia)
    {
        if($formularioEmergencia->estado=="Finalizado" && $user->hasAnyRole(['Jefe de operaciones'])){
            return true;
        }else{
            return false;
        }
    }
    
}
