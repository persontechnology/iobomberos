<?php

namespace iobom\Http\Controllers\Descargos;

use Illuminate\Http\Request;
use iobom\DataTables\Descargos\InsumoDataTable;
use iobom\Http\Controllers\Controller;
use iobom\Models\Descargo\Insumo;
use Illuminate\Support\Facades\DB;
class Insumos extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de insumos y medicamentos']);
    }

    public function index(InsumoDataTable $dataTable)
    {
        return  $dataTable->render('descargo.insumos.index');  
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:insumos|max:191',
        ]);

        $insumo=new Insumo();
        $insumo->nombre=$request->nombre;
        $insumo->save();
        $request->session()->flash('success','Insumo registrado exitosamente');
        return redirect()->route('insumos');
    }

    public function editar($idInsumo)
    {
        $insumo=Insumo::findOrFail($idInsumo);
        return  view('descargo.insumos.editar',['insumo'=>$insumo]);  
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'insumo'=>'required|exists:insumos,id',
            'nombre' => 'required|max:191|unique:insumos,nombre,'.$request->insumo,
        ]);

        $insumo=Insumo::findOrFail($request->insumo);
        $insumo->nombre=$request->nombre;
        $insumo->save();
        $request->session()->flash('success','Insumo actualizado exitosamente');
        return redirect()->route('insumos');
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'insumo'=>'required|exists:insumos,id',
        ]);

        try {
            DB::beginTransaction();
            $estacion=Insumo::findOrFail($request->insumo);
            $estacion->delete();
            DB::commit();
            return response()->json(['success'=>'Insumo eliminado exitosamente']);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar insumo']);
        }
    }
    
}
