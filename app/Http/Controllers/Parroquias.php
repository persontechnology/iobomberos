<?php

namespace iobom\Http\Controllers;
use iobom\DataTables\ParroquiasDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use iobom\Models\Parroquia;


class Parroquias extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de puntos de referencias']);
    }
    public function index(ParroquiasDataTable $dataTable)
    {
        return  $dataTable->render('parroquias.index');
    }
    public function  guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:parroquias|max:191',
            'codigo' => 'required|unique:parroquias',
        ]);
        $parroquia= new Parroquia();
        $parroquia->nombre=$request->nombre;
        $parroquia->codigo=$request->codigo; 
        $parroquia->save();
        
        return redirect()->route('parroquias')->with('success','Parroquia registrada exitosamente');
    }

    public function editar($idParroquia)
    {
        $parroquia=Parroquia::findOrFail($idParroquia);
        return view('parroquias.editar',['parroquia'=>$parroquia]);
    }
    
    public function actualizar(Request $request)
    {
         $request->validate([
            'parroquia'=>'required|exists:parroquias,id',
            'nombre' => 'required|max:191|unique:parroquias,nombre,'.$request->parroquia,
            'codigo' => 'required|max:191|unique:parroquias,codigo,'.$request->parroquia,
        ]);
        $parroquia=Parroquia::findOrFail($request->parroquia);
        $parroquia->nombre=$request->nombre;
        $parroquia->codigo=$request->codigo; 
        
        $parroquia->save();
        return redirect()->route('parroquias')->with('success','Parroquia editada exitosamente');
    }

    
    public function eliminar(Request $request)
    {
         $request->validate([
            'parroquia'=>'required|exists:parroquias,id',
        ]);
        try {
            DB::beginTransaction();
            $parroquia=Parroquia::findOrFail($request->parroquia);
            $parroquia->delete();
            DB::commit();
            return response()->json(['success'=>'Parroquia eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar clínica']);
        }
    }
}
