<?php

namespace iobom\Http\Controllers\formularios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use iobom\DataTables\Formularios\FormularioEmergenciasDataTable;
use iobom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use iobom\Http\Requests\FormularioEmergencia\RqIngreso;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\Asistencia\AsistenciaVehiculo;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\Edificacion;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\FormularioEmergencia\EtapaIncendio;
use iobom\Models\FormularioEmergencia\FormularioEstacionVehiculo;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;
use iobom\Models\Vehiculo;
use iobom\User;
use iobom\Models\FormularioEmergencia\VehiculoOperador;

class FormularioEmergencias extends Controller
{
    
    public function index(FormularioEmergenciasDataTable $dataTable)
    {
        return  $dataTable->render('formularios.formulariosEmergencias.index');
    }
    
    public function nuevo( )
    {
        
        $emergencias=Emergencia::get();
        $puntoReferencias=PuntoReferencia::get();
        $parroquias=Parroquia::get();
        $estacines=Estacion::get();
        //buscar usuario que esten el la lista 
        $diaHoy=Carbon::now();
        $sumarUnDia=$diaHoy->addDays(1);
        $fechaMenor=$diaHoy->setDateTime($sumarUnDia->year,$sumarUnDia->month,$sumarUnDia->day,7,30,0,0)->toDateTimeString();
        $asistenciaHoy=Asistencia::where('fecha',Carbon::now()->toDateString())
        ->where('fechaFin','<=',$fechaMenor)->get();
        $astenciaPersonal=AsistenciaPersonal::
        whereIn('asistencia_id',$asistenciaHoy->pluck('id'))->get();
        $user = User::whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');
        })->get();
        $asistenciaHoyFitro=$astenciaPersonal->whereIn('user_id',$user->pluck('id'));      
        //fin de la busqueda de usuarios
     
        $data = array('emergencias' => $emergencias,
                    'puntoReferencias'=>$puntoReferencias,
                    'estaciones'=>$estacines, 
                    'parroquias'=>$parroquias,
                    'asistenciaHoy'=> $asistenciaHoyFitro,       
                );
        return view('formularios.formulariosEmergencias.nuevo',$data);
        
    }

    public function buscarPuntoReferenciaId(Request $request)
    {
        $puntoReferencia=PuntoReferencia::findOrFail($request->id);
        if($puntoReferencia){
            return response()->json($puntoReferencia);
        }else{
            return response()->json(['data'=>'error']);
        }
    }

    public function guardarFormulario(RqIngreso $request)
    {

        
        try {
            DB::beginTransaction();
            $numero=FormularioEmergencia::latest()->value('numero');
            if($numero){
                $numero=$numero+1;
            }else{
                $numero=1;
            }
            
            $form=new FormularioEmergencia();
            $form->numero=$numero;
            $form->fecha=Carbon::now();
            $form->horaSalida=Carbon::now()->toTimeString();

            $form->institucion=$request->institucion;
            $form->formaAviso=$request->formaAviso;;
            $form->estado='Asignado';
            $form->frecuencia=$request->frecuencia;
            $form->puntoReferencia_id=$request->puntoReferencia;

            // maxima autoridad
            $maximaAutoridad = User::role('Máxima autoridad')->first();
            $form->maximaAutoridad_id=$maximaAutoridad->id??null;
            $form->emergencia_id=$request->emergencia;
            $form->creadoPor=Auth::id();
            
            $form->save();
            //actualizar encargado del formulario
            $encargadoFormulario=FormularioEmergencia::findOrFail($form->id);
            $encargadoFormulario->encardadoFicha_id=$request->encargadoFormulario;
            $encargadoFormulario->save();
            // crear formulario y estacione selecionados
            $i=0;
            foreach ($request->vehiculos as $vehiculos) {
                $asistenciaVehiculo=AsistenciaVehiculo::findOrFail($vehiculos);
                $estacionFOrmulara=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                ->where('formularioEmergencia_id',$form->id)
                ->count();
                $estacionFormularioEmergencia=new EstacionFormularioEmergencia();
                $formularioEstacionVehiculo=new FormularioEstacionVehiculo();
                $vehiculoOperador=new VehiculoOperador();
                $personalOperado=AsistenciaPersonal::where('id',$request->operador[$i])->first();
                if($estacionFOrmulara==0){
                    $estacionFormularioEmergencia->estacion_id=$asistenciaVehiculo->vehiculo->estacion_id;
                    $estacionFormularioEmergencia->formularioEmergencia_id=$form->id;                    
                    $estacionFormularioEmergencia->save();
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularioEmergencia->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                  
                    $formularioEstacionVehiculo->save();
                    $vehiculoOperador->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                    $vehiculoOperador->asistenciaPersonal_id=$request->operador[$i];
                    $vehiculoOperador->save();
                }else{
                    $estacionFormularaPrimero=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                    ->where('formularioEmergencia_id',$form->id)->first();
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularaPrimero->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                 
                    $formularioEstacionVehiculo->save();
                    $vehiculoOperador->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                    $vehiculoOperador->asistenciaPersonal_id=$request->operador[$i];
                    $vehiculoOperador->save();
                }
                $asistenciaVehiculo->estadoEMergencia="Emergencia";
                $asistenciaVehiculo->save();
                $personalOperado->estadoEMergencia="Emergencia";
                $personalOperado->save();
                     $i++;
            }
            DB::commit();
            $request->flash('success','Formulario # '.$form->numero.' registrado exitosamente');
            return redirect()->route('formularios');
        } catch (\Exception $th) {
            DB::rollback();
            // $request->session()->flash('danger','Ocurrio un error, vuelva intentar');
            // return redirect()->route('formularios');
            echo $th;
        }
    }
    
    public function completarFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $data = array('formu' => $formulario );
        return view('formularios.formulariosEmergencias.completarFormulario',$data);

    }

    public function cargarPersonalUnidadesDespachadas($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $estacionsSi=$formulario->estaciones;
        $estacionsNo=Estacion::whereNotIn('id',$formulario->estaciones->pluck('id'))->get();
        $data = array('formu' => $formulario,'estacionesSi'=>$estacionsSi,'estacionesNo'=>$estacionsNo );
        return view('formularios.formulariosEmergencias.cargarPersonalUnidadesDespachadas',$data);
    }

    public function cerarEtapasIncendiEdificacion(Request $request)
    {
        $formulario=FormularioEmergencia::findOrFail($request->formulario);
        if($formulario->etpaIncendio && $formulario->edificacion){
            return response(['success'=>'existe']);
        }else{
            $etapa=new EtapaIncendio();
            $etapa->formularioEmergencia_id=$formulario->id;
            $etapa->save();
            $edificacion=new Edificacion();
            $edificacion->formularioEmergencia_id=$formulario->id;
            $edificacion->save();
            return response(['success'=>'ok']);
        }
        
    }
    public function buscarPersonalOperador(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesAscendente()
        ->whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push( $data,$usuario->getRoleNames()->first().'--'.$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }
    public function buscarPersonalOperativo(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesDescendente()
        ->whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push( $data,$usuario->getRoleNames()->first().'--'.$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }

    public function buscarPersonalParamedico(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesAscendente()
        ->whereHas('roles', function($q){
            $q->where('name', 'Paramédico');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push($data ,$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }
}
