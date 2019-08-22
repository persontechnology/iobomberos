<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\PuntoReferencia;
use iobom\DataTables\PuntosReferenciasDataTable;
use Illuminate\Support\Facades\Auth;
use iobom\Models\Estacion;

class PuntosReferencias extends Controller
{
    public function index(PuntosReferenciasDataTable $dataTable)
    {
    	
    	return $dataTable->render('puntosReferencias.index');
    }
    
    public function nuevo()
    {   $estaciones=Estacion::get();
       return view('puntosReferencias.nuevo',['estaciones'=>$estaciones]);
    }
    public function guardar(Request $request)
    {
    	$request->validate([
            'latitud' => 'required|max:191',
            'longitud' => 'required|max:191',
            'direccion' => 'required|max:191',
        ]);
    	$puntoReferencia= new PuntoReferencia();
    	$puntoReferencia->latitud=$request->latitud;
    	$puntoReferencia->longitud=$request->longitud;
    	$puntoReferencia->direccion=$request->direccion;
    	$puntoReferencia->creadoPor=Auth::id();
    	$puntoReferencia->save();
    	 return redirect()->route('puntosReferencia')->with('success','Punto de referencia registrado exitosamente');
    }
    public function mapa()
    {
    	 $estaciones=Estacion::get();
    	 $puntos=PuntoReferencia::get();
       return view('puntosReferencias.mapa',['estaciones'=>$estaciones,'puntos'=>$puntos]);
    }
}
