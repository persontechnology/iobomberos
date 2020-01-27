<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\Emergencia\Emergencia;

class Reportes extends Controller
{
    public function estadisticas()
    {
        $fecha="2020-01";
        $emergencia=Emergencia::get();
        
        // foreach ($emergencia as $emergencia) {
        //     echo $emergencia->formularios ."</br>";

        // }
        $data = array('emergencias' =>$emergencia , );
        return view('reportes.estadisticas',$data);
    }
}
