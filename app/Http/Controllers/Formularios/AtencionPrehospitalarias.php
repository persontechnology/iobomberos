<?php

namespace iobom\Http\Controllers\Formularios;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\Models\Clinica;
use iobom\Models\Descargo\Insumo;
use iobom\Models\FormularioEmergencia;

class AtencionPrehospitalarias extends Controller
{
    public function nuevo($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $clinicas=Clinica::get();
        $insumos=Insumo::get();
        $data = array('formulario' => $formulario,'clinicas'=>$clinicas,'insumos'=>$insumos);
        return view('formularios.atencionPrehospitalarias.nuevo',$data);

    }
}
