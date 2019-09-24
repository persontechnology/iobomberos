<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\Clinica;
use iobom\DataTables\ClinicasDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Clinicas extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de clínicas']);
    }
    
    
    public function index(ClinicasDataTable $dataTable)
    {
       return  $dataTable->render('clinicas.index');  
    }

   
    public function  guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:clinica|max:191',
        ]);
        $clinica= new Clinica();
        $clinica->nombre=$request->nombre;
        $clinica->creadoPor=Auth::id();
        $clinica->save();
        
        return redirect()->route('clinicas')->with('success','Clínica registrada exitosamente');
    }

    public function editar($idClinica)
    {
        $clinica=Clinica::findOrFail($idClinica);
        return view('clinicas.editar',['clinica'=>$clinica]);
    }

    
    public function actualizar(Request $request)
    {
         $request->validate([
            'clinica'=>'required|exists:clinica,id',
            'nombre' => 'required|max:191|unique:clinica,nombre,'.$request->clinica,
           
        ]);
        $clinica=Clinica::findOrFail($request->clinica);
        $clinica->nombre=$request->nombre;
        $clinica->actualizadoPor=Auth::id();
        $clinica->save();
        return redirect()->route('clinicas')->with('success','Clínica editada exitosamente');
    }

    
    public function eliminar(Request $request)
    {
         $request->validate([
            'clinica'=>'required|exists:clinica,id',
        ]);
        try {
            DB::beginTransaction();
            $clinica=Clinica::findOrFail($request->clinica);
            $clinica->delete();
            DB::commit();
            return response()->json(['success'=>'Clínica eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar clínica']);
        }
    }
}
