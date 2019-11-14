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
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\Edificacion;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\FormularioEmergencia\EtapaIncendio;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;
use iobom\Models\Vehiculo;
use iobom\User;

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
        $data = array('emergencias' => $emergencias,
                    'puntoReferencias'=>$puntoReferencias,
                    'estaciones'=>$estacines, 
                    'parroquias'=>$parroquias,        
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


            // crear formulario y estacione selecionados
            foreach ($request->estaciones as $estacion) {
                $estacionFormularioEmergencia=new EstacionFormularioEmergencia();
                $estacionFormularioEmergencia->estacion_id=$estacion;
                $estacionFormularioEmergencia->formularioEmergencia_id=$form->id;
                $estacionFormularioEmergencia->save();
            }

            DB::commit();
            $request->flash('success','Formulario # '.$form->numero.' registrado exitosamente');
            return redirect()->route('completarFormulario',$form->id);
        } catch (\Exception $th) {
            DB::rollback();
            $request->flash('danger','Ocurrio un error, vuelva intentar');
            return redirect()->route('formularios');
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
