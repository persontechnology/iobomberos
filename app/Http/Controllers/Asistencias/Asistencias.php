<?php

namespace iobom\Http\Controllers\Asistencias;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use iobom\Http\Controllers\Controller;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\Asistencia\AsistenciaVehiculo;
use iobom\Models\Estacion;

class Asistencias extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','permission:Generar asistencia']);
    }

    public function index()
    {
        $estaciones=Estacion::all();
        $data = array('estaciones' => $estaciones );
        return view('asistencias.index',$data);
    }

    public function listadoPersonal($Idestacion)
    {
        $estacion=Estacion::findOrFail($Idestacion);
        $this->authorize('generarAsistencia', $estacion);

        $asistencia=Asistencia::where(['estacion_id'=>$estacion->id,'fecha'=>Carbon::now()->toDateString()])->first();
        
        if (!$asistencia) {
            $asistencia=new Asistencia();
            $asistencia->estacion_id=$estacion->id;
            $asistencia->fecha=Carbon::now()->toDateString();
            $asistencia->user_id=Auth::id();
            $asistencia->save();
        }
        
        $asistencia->asistenciaPersonal()->sync($estacion->personales->pluck('id'));
        $asistencia->asistenciaVehiculo()->sync($estacion->vehiculos->pluck('id'));

        $data = array('estacion' =>$estacion ,'personales'=>$asistencia->asistenciaPersonal,'vehiculos'=>$asistencia->asistenciaVehiculo );
        return view('asistencias.listadoPersonal',$data);
    }

    public function estadoPersonal(Request $request)
    {
        $asistenciaPersonal=AsistenciaPersonal::findOrFail($request->id);
        if($asistenciaPersonal->estado){
            $asistenciaPersonal->estado=false;
        }else{
            $asistenciaPersonal->estado=true;
            $asistenciaPersonal->observacion='';
        }
        $asistenciaPersonal->save();
        return response()->json(['success'=>$asistenciaPersonal]);
    }

    public function estadoVehiculo(Request $request)
    {
        $asistenciaVehiculo=AsistenciaVehiculo::findOrFail($request->id);
        if($asistenciaVehiculo->estado){
            $asistenciaVehiculo->estado=false;
        }else{
            $asistenciaVehiculo->estado=true;
            $asistenciaVehiculo->observacion='';
        }
        $asistenciaVehiculo->save();
        return response()->json(['success'=>$asistenciaVehiculo]);
    }
}
