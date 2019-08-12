<?php

namespace iobom\Http\Controllers\Emergencias;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\Emergencias\TipoEmergenciaDataTable;
use iobom\Models\Emergencia\TipoEmergencia;
use Illuminate\Support\Facades\Auth;
use iobom\Models\Emergencia\Emergencia;
use Illuminate\Support\Facades\DB;

class TipoEmergencias extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de emergencia']);
    }

    public function index(TipoEmergenciaDataTable $dataTable,$idEmergencia)
    {
        $emergencia=Emergencia::findOrFail($idEmergencia);
        return $dataTable->with('id',$emergencia->id)
        ->render('emergencias.tipo.index',compact('emergencia'));
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tipoEmergencia|max:191',
            'emergencia'=>'required|exists:emergencia,id'
        ]);
        TipoEmergencia::create([
            'nombre'=>$request->nombre,
            'emergencia_id'=>$request->emergencia,
            'creadoPor'=>Auth::id()
        ]);
        return redirect()->route('tipoEmergencia',$request->emergencia)->with('success','Tipo de emergencia guardado exitosamente');
    }

    public function editar($idTipoEmergencia)
    {
        $tipoEmergencia=TipoEmergencia::findOrFail($idTipoEmergencia);
        return view('emergencias.tipo.editar',compact('tipoEmergencia'));
    }
    
    
    public function actualizar(Request $request)
    {
        $request->validate([
            'teme'=>'required|exists:tipoEmergencia,id',
            'nombre' => 'required|max:191|unique:tipoEmergencia,nombre,'.$request->teme,
        ]);
        $eme=TipoEmergencia::findOrFail($request->teme);
        $eme->nombre=$request->nombre;
        $eme->actualizadoPor=Auth::id();
        $eme->save();
        return redirect()->route('tipoEmergencia',$eme->emergencia->id)->with('success','Cambios guardado');
    }

    
    public function eliminar(Request $request)
    {
        $request->validate([
            'teme'=>'required|exists:tipoEmergencia,id',
        ]);
        try {
            DB::beginTransaction();
            $eme=TipoEmergencia::findOrFail($request->teme);
            $eme->delete();
            DB::commit();
            return response()->json(['success'=>'T. Emergencia eliminado exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar tipo de emergencia']);
        }
    }
}
