<?php

namespace iobom\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\FormularioEmergencia;
use PDF;

class Reportes extends Controller
{
    public function estadisticas(Request $request)
    {
        
        $emergencia=Emergencia::get();       
      
        $data = array('emergencias' =>$emergencia ,'fecha'=>$request->fecha );
        return view('reportes.estadisticas',$data);
    }
    public function resporteMes(Request $request)
    {

        $bucarFormularios=FormularioEmergencia::whereYear('fecha',date('Y',strtotime($request->fecha)))
        ->whereMonth('fecha',date('m',strtotime($request->fecha)))
        ->orderBy('fecha','asc')->get();
        $data = array('formularios' =>$bucarFormularios ,'fecha'=>$request->fecha );
        return view('reportes.reporte',$data);
        
        
    }
    public function exportarReporte($fecha)
    {
        $bucarFormularios=FormularioEmergencia::whereYear('fecha',date('Y',strtotime($fecha)))
        ->whereMonth('fecha',date('m',strtotime($fecha)))
        ->orderBy('fecha','asc')->get();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha1 = Carbon::parse($fecha);
        $mes = $meses[($fecha1->format('n')) - 1];
        $data = array('formularios' =>$bucarFormularios ,'fecha'=>$fecha,'mes'=>$mes );

        $pdf = Pdf::loadView('reportes.exportarPdf', $data)
        ->setOrientation('landscape')
        ->setPaper('a4')
        ->setOption('margin-top', '15')
        ->setOption('margin-bottom', '15')
        ->setOption('margin-left', '15mm')

        ->setOption('margin-right', '15mm');
 
        return $pdf->inline('Reporte-'.$mes.'.pdf');
    }
    public function headrePdf()
    {
        return view('reportes.header');
    }
}
