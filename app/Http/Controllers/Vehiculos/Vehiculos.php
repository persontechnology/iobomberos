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
use iobom\Http\Requests\Vehiculo\RqActualizar;
use iobom\Models\Estacion;
use iobom\Http\Requests\Vehiculo\RqCrear;
use Illuminate\Support\Facades\Storage;
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
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/vehiculos', $request->file('foto'), $vehiculo->id.'.'.$extension
                );
                $vehiculo->foto=$path;
                $vehiculo->save();
            }
        }
        return redirect()->route('vehiculos',$tipo->id)->with('success', 'Vehículo registrado exitosamente');

    }
    public function editar($idVehiculo)
    {
        $vehiculo=Vehiculo::findOrFail($idVehiculo);
        $estaciones=Estacion::all(); 
        $tipoVehiculos=TipoVehiculo::all();
    	return view('vehiculos.vehiculos.editar',compact('vehiculo','estaciones','tipoVehiculos'));
    }
    
    public function actualizar(RqActualizar $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        $vehiculo->estacion_id=$request->estacion;
        $vehiculo->tipoVehiculo_id=$request->tipoVehiculo;
        $vehiculo->placa=$request->placa;
        $vehiculo->codigo=$request->codigo;
        $vehiculo->marca=$request->marca;
        $vehiculo->modelo=$request->modelo;
        $vehiculo->cilindraje=$request->cilindraje;
        $vehiculo->anio=$request->anio;
        $vehiculo->motor=$request->motor;
        $vehiculo->save();
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                Storage::delete($vehiculo->foto);
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/vehiculos', $request->file('foto'), $vehiculo->id.'.'.$extension
                );
                $vehiculo->foto=$path;
                $vehiculo->save();
            }
        }
        return redirect()->route('vehiculos',$request->tipoVehiculo)->with('success', 'Vehículo actualizado exitosamente');
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
