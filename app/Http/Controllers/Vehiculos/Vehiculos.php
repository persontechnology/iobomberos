<?php

namespace iobom\Http\Controllers\Vehiculos;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\VehiculosDataTable;
use iobom\Models\Vehiculo;
use iobom\Models\TipoVehiculo;
use Maatwebsite\Excel\Facades\Excel;
use iobom\Imports\VehiculosImport;

class Vehiculos extends Controller
{
   

    public function __construct()
    {
        $this->middleware(['auth','permission:G. de vehículos']);
    }
    public function index(VehiculosDataTable $dataTable,$idTipo)
    {
    	 $tipo=TipoVehiculo::findOrFail($idTipo);  
    	return $dataTable->with('id',$tipo->id)
        ->render('vehiculos.vehiculos.index',compact('tipo')); 
    }
    public function guardar(Request $request)
    {
    	$request->validate([
            'nombre' => 'required|unique:tipoVehiculo|max:191',
            'codigo' => 'required|unique:tipoVehiculo|max:10',
        ]);
    	$tipoVehiculo= new TipoVehiculo();
    	$tipoVehiculo->nombre=$request->nombre;
    	$tipoVehiculo->codigo=$request->codigo;
    	$tipoVehiculo->save();
    	return redirect()->route('tipoVehiculos')->with('success','Tipo de vehículo registrado exitosamente');

    }
    public function editar($idTipoVehiculo)
    {
    	$tipoVehiculo=TipoVehiculo::findOrFail($idTipoVehiculo);
        return view('vehiculos.tipoVehiculos.editar',['tipoVehiculo'=>$tipoVehiculo]);
    }
     public function actualizar(Request $request)
    {
         $request->validate([
            'tipo'=>'required|exists:tipoVehiculo,id',
            'nombre' => 'required|max:191|unique:tipoVehiculo,nombre,'.$request->tipo,
           	'codigo' => 'required|max:10|unique:tipoVehiculo,codigo,'.$request->tipo,
        ]);
        $tipoVehiculo=TipoVehiculo::findOrFail($request->tipo);
        $tipoVehiculo->nombre=$request->nombre;
        $tipoVehiculo->codigo=$request->codigo;
        $tipoVehiculo->actualizadoPor=Auth::id();
        $tipoVehiculo->save();
        return redirect()->route('tipoVehiculos')->with('success','Tipo de vehículo editada exitosamente');
    }

    
    public function eliminar(Request $request)
    {
         $request->validate([
            'tipo'=>'required|exists:clinica,id',
        ]);
        try {
            DB::beginTransaction();
            $tipoVehiculo=TipoVehiculo::findOrFail($request->tipo);
            $tipoVehiculo->delete();
            DB::commit();
            return response()->json(['success'=>'Tipo de vehículo eliminado exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el tipo de vehículo']);
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
