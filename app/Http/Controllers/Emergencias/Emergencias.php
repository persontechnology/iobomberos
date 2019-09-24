<?php

namespace iobom\Http\Controllers\Emergencias;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\Emergencias\EmergenciaDataTable;
use iobom\Models\Emergencia\Emergencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Emergencias extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de emergencias']);
    }

    public function index(EmergenciaDataTable $dataTable)
    {
        return $dataTable->render('emergencias.index');
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:emergencia|max:191',
        ]);
        Emergencia::create([
            'nombre'=>$request->nombre,
            'creadoPor'=>Auth::id()
        ]);
        return redirect()->route('emergencia')->with('success','Emergencia registrada exitosamente');
    }

    public function editar($idEmergencia)
    {
        $emergencia=Emergencia::findOrFail($idEmergencia);
        return view('emergencias.editar',['eme'=>$emergencia]);
    }
    
    
    public function actualizar(Request $request)
    {
        $request->validate([
            'emergencia'=>'required|exists:emergencia,id',
            'nombre' => 'required|max:191|unique:emergencia,nombre,'.$request->emergencia,
        ]);
        $eme=Emergencia::findOrFail($request->emergencia);
        $eme->nombre=$request->nombre;
        $eme->actualizadoPor=Auth::id();
        $eme->save();
        return redirect()->route('emergencia')->with('success','Emergencia editada exitosamente');
    }

    
    public function eliminar(Request $request)
    {
        $request->validate([
            'emergencia'=>'required|exists:emergencia,id',
        ]);
        try {
            DB::beginTransaction();
            $emergencia=Emergencia::findOrFail($request->emergencia);
            $emergencia->delete();
            DB::commit();
            return response()->json(['success'=>'Emergencia eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar emergencia']);
        }
    }
    
}
