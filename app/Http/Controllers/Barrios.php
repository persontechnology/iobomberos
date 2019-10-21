<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use iobom\DataTables\BarriosDataTable;
use iobom\Models\Barrio;
use iobom\Models\Parroquia;

class Barrios extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de puntos de referencias']);
    }
    public function index(BarriosDataTable $dataTable)
    {
        return  $dataTable->render('barrios.index');
    }
    public function nuevo()
    {
        $parroquias=Parroquia::get();
        $data = array('parroquias' =>$parroquias , );
        return view('barrios.nuevo',$data);
    }
    public function  guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191,|unique:barrios,nombre,'.$request->parroquia,
            'codigo' => 'required|unique:barrios',
            'parroquia'=>'required'
        ]);
        $barrio= new Barrio();
        $barrio->nombre=$request->nombre;
        $barrio->codigo=$request->codigo;
        $barrio->parroquia_id=$request->parroquia; 
        $barrio->save();
        
        return redirect()->route('barrios')->with('success','Parroquia registrada exitosamente');
    }

    public function editar($idBarrio)
    {
        $barrios=Barrio::findOrFail($idBarrio);
        $parroquias=Parroquia::get();
        return view('barrios.editar',['barrio'=>$barrios,'parroquias'=>$parroquias]);
    }
    
    public function actualizar(Request $request)
    {
         $request->validate([
            'parroquia'=>'required|exists:parroquias,id',
            'barrio'=>'required|exists:barrios,id',
            'nombre' => 'required|max:191|unique:barrios,nombre,'.$request->barrio,
            'codigo' => 'required|max:191|unique:barrios,codigo,'.$request->barrio,
        ]);
        $barrio=Barrio::findOrFail($request->barrio);
        $barrio->nombre=$request->nombre;
        $barrio->codigo=$request->codigo;
        $barrio->parroquia_id=$request->parroquia;  
        
        $barrio->save();
        return redirect()->route('barrios')->with('success','Barrio editada exitosamente');
    }

    
    public function eliminar(Request $request)
    {
         $request->validate([
            'barrio'=>'required|exists:barrios,id',
        ]);
        try {
            DB::beginTransaction();
            $barrio=Barrio::findOrFail($request->barrio);
            $barrio->delete();
            DB::commit();
            return response()->json(['success'=>'barrio eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar clínica']);
        }
    }
}
