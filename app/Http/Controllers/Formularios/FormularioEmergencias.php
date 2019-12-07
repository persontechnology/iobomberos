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
use iobom\Models\FormularioEmergencia\VehiculoOperativo;
use iobom\Models\FormularioEmergencia\VehiculoParamedico;

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
        $numero=FormularioEmergencia::latest()->value('numero');
        if($numero){
            $numero=$numero+1;
        }else{
            $numero=1;
        }
        
        $data = array(
            'emergencias' => $emergencias,
            'puntoReferencias'=>$puntoReferencias,
            'estaciones'=>$estacines, 
            'parroquias'=>$parroquias,
            'asistenciaHoy'=> $asistenciaHoyFitro, 
            'numero'=>$numero,      
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
            $form->telefono=$request->telefono;
            $form->formaAviso=$request->formaAviso;;
            $form->estado='Asignado';
            $form->frecuencia=$request->frecuencia;
            $form->puntoReferencia_id=$request->puntoReferencia;
            $form->localidad=$request->direcionAdicional;

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
            // crear formulario y los vehiculos asignados
            $i=0;
            foreach ($request->vehiculos as $vehiculos) {
                //Buscar asistencia del vehiculo en el dia
                $asistenciaVehiculo=AsistenciaVehiculo::findOrFail($vehiculos);
                //buscar si existe una estacion de formulario de emergencia 
                $estacionFOrmulara=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                ->where('formularioEmergencia_id',$form->id)
                ->count();
                $estacionFormularioEmergencia=new EstacionFormularioEmergencia();
                $formularioEstacionVehiculo=new FormularioEstacionVehiculo();                              
                
                //verifiacar si la estacion ya esta registrada
                if($estacionFOrmulara==0){
                    //guardar la estacion a quien pertence el vehiculo
                    $estacionFormularioEmergencia->estacion_id=$asistenciaVehiculo->vehiculo->estacion_id;
                    $estacionFormularioEmergencia->formularioEmergencia_id=$form->id;                    
                    $estacionFormularioEmergencia->save();
                    //guardar vehiculo en cada uno de las estaciones
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularioEmergencia->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                  
                    $formularioEstacionVehiculo->save();
                    //buscar estacion del formulario
                    $buscarestacionEstacion=EstacionFormularioEmergencia::findOrFail($estacionFormularioEmergencia->id);
                        foreach($request->encargadoEstacion as $encargadoEstacion){
                            $variableAuxEnca=explode('-',$encargadoEstacion);
                            if($buscarestacionEstacion->estacion_id==$variableAuxEnca[0]){
                                $asistenciaPersonalEstacion=AsistenciaPersonal::findOrFail($variableAuxEnca[1]);             
                                $buscarestacionEstacion->user_id= $asistenciaPersonalEstacion->user_id;
                                $buscarestacionEstacion->save();
                                $asistenciaPersonalEstacion->estadoEmergencia='Emergencia';
                                $asistenciaPersonalEstacion->save();
                            }
                        }
                        
                    
                }else{
                    //Buscar si la estacion existe en la asignacion del formulario 
                    $estacionFormularaPrimero=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                    ->where('formularioEmergencia_id',$form->id)->first();
                    //guardar la estacion a quien pertence el vehiculo
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularaPrimero->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                 
                    $formularioEstacionVehiculo->save();                    
                 
                }
                //guardar operador en cada veiculo registrado
                if($request->operador[$i]){
                $vehiculoOperador=new VehiculoOperador();  
                $vehiculoOperador->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                $vehiculoOperador->asistenciaPersonal_id=$request->operador[$i];
                $vehiculoOperador->save();
                }
                //guardar Acompañantes en cada vehiculo
                foreach ($request->operativos as $operativo ) {
                    $variableAux=explode('-',$operativo);
                     if($variableAux[0]==$asistenciaVehiculo->id){
                        $personalOperacional=new VehiculoOperativo();                                           
                        $personalOperacional->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                        $personalOperacional->asistenciaPersonal_id=$variableAux[1];
                        $personalOperacional->save();
                        //cambiar estado al personal
                        $asistenciaPersonal=AsistenciaPersonal::findOrFail($variableAux[1]);
                        $asistenciaPersonal->estadoEmergencia='Emergencia';
                        $asistenciaPersonal->save();                         
                     }
                }
                //guardar Paramedico
                
                if($request->paramedico[$i]){
                $vehiculoParamedico=new VehiculoParamedico();  
                $vehiculoParamedico->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                $vehiculoParamedico->asistenciaPersonal_id=$request->paramedico[$i];
                $vehiculoParamedico->save();
                $personalParamedico=AsistenciaPersonal::where('id',$request->paramedico[$i])->first();
                $personalParamedico->estadoEMergencia="Emergencia";
                $personalParamedico->save();
                }
                // cambiar de estado al vehiculo 
                $asistenciaVehiculo->estadoEMergencia="Emergencia";
                $asistenciaVehiculo->save();
                // cambiar de estado del operador asignado a la emergencia
                $personalOperado=AsistenciaPersonal::where('id',$request->operador[$i])->first();
                $personalOperado->estadoEMergencia="Emergencia";
                $personalOperado->save();
                $i++;
            }
            DB::commit();
            $request->flash('success','Formulario # '.$form->numero.' registrado exitosamente');
        } catch (\Exception $th) {
            DB::rollback();
            $request->session()->flash('danger','Ocurrio un error, vuelva intentar');
        }
        return redirect()->route('formularios');
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
    public function informacionFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        // $user=User::findOrFail($formulario->cread)
        $data = array('formulario' => $formulario, );
        return view('formularios.formulariosEmergencias.informacion',$data);
    }
}
