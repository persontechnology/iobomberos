<?php

namespace iobom\Http\Controllers\formularios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use iobom\DataTables\Formularios\FormularioEmergenciasDataTable;
use iobom\Http\Controllers\Controller;
use iobom\Models\Asistencia\Asistencia;
use Illuminate\Support\Facades\Auth;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;

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
    public function guardarFormulario(Request $request)
    {
        $fechaHoy=Carbon::now();
        $formulario=new FormularioEmergencia();
        $formulario->numero=1;
        $formulario->fecha=$fechaHoy->toDateString();
        $formulario->horaSalida=$fechaHoy->toTimeString();
        $formulario->institucion=$request->institucion;
        $formulario->formaAviso=$request->formaAviso;
        $formulario->puntoReferencia_id=$request->puntoReferencia;
        $formulario->emergencia_id=$request->emergencia;
        $formulario->creadoPor=Auth::id();
        $formulario->save();
        $request->flash('success','Formulario registrado exitosamente');

        return redirect()->route('formularios');
    }
    public function crearProceso($idFormulario)
    {
        $formuralrio=FormularioEmergencia::findOrFail($idFormulario);
        return view('formularios.formulariosEmergencias.nuevo');

    }

}
