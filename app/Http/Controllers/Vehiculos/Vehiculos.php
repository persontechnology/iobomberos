<?php

namespace iobom\Http\Controllers\Vehiculos;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\VehiculosDataTable;
use iobom\Models\Vehiculo;
use iobom\Models\TipoVehiculo;
use Maatwebsite\Excel\Facades\Excel;
use iobom\Imports\VehiculosImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use iobom\Models\Estacion;
use iobom\Http\Requests\Vehiculo\RqCrear;

class Vehiculos extends Controller
{
   

    public function __construct()
    {
        $this->middleware(['auth','permission:G. de vehículos']);
    }
    public function index(VehiculosDataTable $dataTable,$idTipo)
    {
    	 $tipo=TipoVehiculo::findOrFail($idTipo);  
    	return $dataTable->with('idTipo',$tipo->id)
        ->render('vehiculos.vehiculos.index',compact('tipo')); 
    }
    public function nuevo($idTipo)
    {
       $tipo=TipoVehiculo::findOrFail($idTipo); 
       $estaciones=Estacion::all(); 
      return view('vehiculos.vehiculos.nuevo',["tipo"=>$tipo,"estaciones"=>$estaciones]);
    }
    public function guardar(RqCrear $request)
    {
    	$tipo=TipoVehiculo::findOrFail($request->tipo); 
      $vehiculo= new Vehiculo();
      $vehiculo->estacion_id=$request->estacion;
      $vehiculo->tipoVehiculo_id=$tipo->id;
      $vehiculo->placa=$request->placa;
      $vehiculo->codigo=$request->codigo;
      $vehiculo->marca=$request->marca;
      $vehiculo->modelo=$request->modelo;
      $vehiculo->cilindraje=$request->cilindraje;
      $vehiculo->anio=$request->anio;
      $vehiculo->motor=$request->motor;
      $vehiculo->save();
      return redirect()->route('vehiculos',$tipo->id)->with('success', 'Vehículos registrados exitosamente');

    }
    public function editar($idTipoVehiculo)
    {
    	
    }
     public function actualizar(Request $request)
    {
         
    }

    
    public function eliminar(Request $request)
    {
         $request->validate([
            'vehiculo'=>'required|exists:vehiculo,id',
        ]);
        try {
            DB::beginTransaction();
            $vehiculo=Vehiculo::findOrFail($request->vehiculo);
            $vehiculo->delete();
            DB::commit();
            return response()->json(['success'=>'Vehículo eliminado exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el  vehículo']);
        }
    }
    public function importar()
    {
    	return view('vehiculos.vehiculos.importar');
    }

      public function importarArchivo(Request $request)
  {
  	$this->validate($request,[
  		'archivo'=>'required|mimes:xls,xlsx'
  	]);    	
  	Excel::import(new VehiculosImport, request()->file('archivo'));
  	return redirect()->route('tipoVehiculos')->with('success', 'Vehículos importados exitosamente');
  }
}
