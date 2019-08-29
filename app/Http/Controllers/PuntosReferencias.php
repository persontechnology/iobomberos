<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\PuntoReferencia;
use iobom\DataTables\PuntosReferenciasDataTable;
use Illuminate\Support\Facades\Auth;
use iobom\Models\Estacion;
use Illuminate\Support\Facades\DB;

class PuntosReferencias extends Controller
{
    public function index(PuntosReferenciasDataTable $dataTable)
    {
    	
    	return $dataTable->render('puntosReferencias.index');
    }
    
    public function nuevo()
    {   $estaciones=Estacion::get();
        $puntos=PuntoReferencia::get();
       return view('puntosReferencias.nuevo',['estaciones'=>$estaciones,'puntos'=>$puntos]);
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
    public function editar($idPunto)
    {
       $puntoReferencia=PuntoReferencia::findOrFail($idPunto);
        $estaciones=Estacion::get();
        $puntos=PuntoReferencia::get();
       return view('puntosReferencias.editar',['estaciones'=>$estaciones,'puntos'=>$puntos,'puntoReferencia'=>$puntoReferencia]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'latitud' => 'required|max:191',
            'longitud' => 'required|max:191',
            'direccion' => 'required|max:191',
            'punto'=>'required'
        ]);
        $puntoReferencia= PuntoReferencia::findOrFail($request->punto);
        $puntoReferencia->latitud=$request->latitud;
        $puntoReferencia->longitud=$request->longitud;
        $puntoReferencia->direccion=$request->direccion;
        $puntoReferencia->actualizadoPor=Auth::id();
        $puntoReferencia->save();
         return redirect()->route('puntosReferencia')->with('success','Punto de referencia actualizado exitosamente');
    }

    public function eliminar(Request $request)
    {
         $request->validate([
            'PuntoReferencia'=>'required|exists:puntoReferencia,id',
        ]);
        try {
            DB::beginTransaction();
            $PuntoReferencia=PuntoReferencia::findOrFail($request->PuntoReferencia);
            $PuntoReferencia->delete();
            DB::commit();
            return response()->json(['success'=>'Punto de referencia eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el punto de referencia']);
        }
    }
}
