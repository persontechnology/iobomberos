<?php

namespace iobom\Http\Controllers\formularios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use iobom\DataTables\Formularios\FormularioEmergenciasDataTable;
use iobom\Http\Controllers\Controller;
use iobom\Models\Asistencia\Asistencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use iobom\Http\Requests\FormularioEmergencia\RqIngreso;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;
use iobom\User;
use PhpParser\Node\Stmt\TryCatch;

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
            $request->flash('success','Formulario registrado exitosamente');
        } catch (\Exception $th) {
            DB::rollback();
            $request->flash('danger','Ocurrio un error, vuelva intentar');
        }

        return redirect()->route('formularios');
    }
    
    public function crearProceso($idFormulario)
    {
        $formuralrio=FormularioEmergencia::findOrFail($idFormulario);
        return view('formularios.formulariosEmergencias.nuevo');

    }

}
