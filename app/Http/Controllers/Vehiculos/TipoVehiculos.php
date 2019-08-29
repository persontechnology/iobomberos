<?php

namespace iobom\Http\Controllers\Vehiculos;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\TipoVehiculoDataTable;
use iobom\Models\TipoVehiculo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoVehiculos extends Controller
{
	 public function __construct()
    {
        $this->middleware(['auth','permission:G. de vehículos']);
    }
    public function index(TipoVehiculoDataTable $dataTable)
    {
    	return  $dataTable->render('vehiculos.tipoVehiculos.index');	 
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
}
