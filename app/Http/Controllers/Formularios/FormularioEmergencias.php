<?php

namespace iobom\Http\Controllers\formularios;

use Illuminate\Http\Request;
use iobom\DataTables\Formularios\FormularioEmergenciasDataTable;
use iobom\Http\Controllers\Controller;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
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
        $estacines=Estacion::get();
        $data = array('emergencias' => $emergencias,'puntoReferencias'=>$puntoReferencias,'estacines'=>$estacines );
        return view('formularios.formulariosEmergencias.nuevo',$data);
        
    }
    public function guardarFormulario(Request $request)
    {
        $formulario=new FormularioEmergencia();
        
    }
    public function crearProceso($idFormulario)
    {
        $formuralrio=FormularioEmergencia::findOrFail($idFormulario);
        return view('formularios.formulariosEmergencias.nuevo');

    }

}
