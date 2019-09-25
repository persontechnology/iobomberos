<?php

namespace iobom\Http\Controllers\Descargos;

use Illuminate\Http\Request;
use iobom\DataTables\Descargos\MedicamentoDataTable;
use iobom\Http\Controllers\Controller;
use iobom\Models\Descargo\Insumo;
use iobom\Models\Descargo\Medicamento;
use Illuminate\Support\Facades\DB;

class Medicamentos extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de insumos y medicamentos']);
    }

    public function index(MedicamentoDataTable $dataTable,$idInsummo)
    {
        $insumo=Insumo::findOrFail($idInsummo);
        return  $dataTable->with('insumo',$insumo)->render('descargo.medicamentos.index',['insumo'=>$insumo]);  
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:medicamentos|max:191',
            'insumo'=>'required|exists:insumos,id'
        ]);
        $medicamento=new Medicamento();
        $medicamento->nombre=$request->nombre;
        $medicamento->insumo_id=$request->insumo;
        $medicamento->save();
        $request->session()->flash('success','Medicamento registrado exitosamente');
        return redirect()->route('medicamentos',$request->insumo);
    }

    public function editar($Idmedi)
    {
        $medi=Medicamento::findOrFail($Idmedi);
        return view('descargo.medicamentos.editar',['medi'=>$medi]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'medi'=>'required|exists:medicamentos,id',
            'nombre' => 'required|max:191|unique:medicamentos,nombre,'.$request->medi,
        ]);

        $medicamento=Medicamento::findOrFail($request->medi);
        $medicamento->nombre=$request->nombre;
        $medicamento->save();
        $request->session()->flash('success','Medicamento actualizado exitosamente');
        return redirect()->route('medicamentos',$medicamento->insumo->id);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'medi'=>'required|exists:medicamentos,id',
        ]);

        try {
            DB::beginTransaction();
            $estacion=Medicamento::findOrFail($request->medi);
            $estacion->delete();
            DB::commit();
            return response()->json(['success'=>'Medicamento eliminado exitosamente']);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar medicamento']);
        }
    }
}
