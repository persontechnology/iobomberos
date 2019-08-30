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
    public function guardar(Request $request)
    {
    	

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
