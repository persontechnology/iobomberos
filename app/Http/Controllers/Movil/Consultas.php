<?php

namespace iobom\Http\Controllers\Movil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use iobom\Http\Controllers\Controller;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\VehiculoOperador;
use iobom\Models\FormularioEmergencia\VehiculoOperativo;
use iobom\Models\FormularioEmergencia\VehiculoParamedico;
use iobom\User;

class Consultas extends Controller
{
    public function login($email,$pass)
    {
        $user=User::where('email',$email)->first();
        if($user){
            if (Hash::check($pass, $user->password)) {
                $data = array(
                    'id' => $user->id ,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'state_user'=>true,
                    'perfil'=>$user->perfil
                );
                return response()->json($data);
            }
        }
        return response()->json(null);
    }
    public function consultaFormularios($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        $asistencia=$user->asistenciaConsultas->first();
        $variable=0;
        if($asistencia){
            $variable=1;
        $operador=VehiculoOperador::where('asistenciaPersonal_id',$asistencia->pivot->id)->get();
        $operativo=VehiculoOperativo::where('asistenciaPersonal_id',$asistencia->pivot->id)->get();
        $paramedico=VehiculoParamedico::where('asistenciaPersonal_id',$asistencia->pivot->id)->get();
        $data = array(
                        'operador' =>$operador ,
                        'operativo' =>$operativo , 
                        'paramedico' =>$paramedico,
                         'variable' =>$variable,
                         'usuario'=>$user,
                    );
        
        return view('consultas.formulario',$data);
        }else{
            $data = array(
                 'variable' =>$variable
            );
            return view('consultas.formulario',$data);;
        }
    }

    public function consultaMisFormularios($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        $asitencias=AsistenciaPersonal::where('user_id',$user->id)->get();
        $formularios=FormularioEmergencia::whereIn('encardadoFicha_id',$asitencias->pluck('id'))
        ->where('estado','!=','Finalizado')->orderBy('numero','desc')->get();
        $data = array('usuario' =>$user ,'formularios'=>$formularios );
        return view('consultas.misFormularios',$data);
      

    }
}
