<?php

namespace iobom\Http\Controllers\Sistema;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\Sistema\RolesDataTable;
use Spatie\Permission\Models\Role;
class Roles extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrador','auth']);
    }

    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('sistema.roles.index');
    }

    public function guardar(Request $request)
    {
        $validatedData = $request->validate([
            'rol' => 'required|unique:roles,name|max:255',
        ]);
        Role::create(['name' => $request->rol]);
        $request->session()->flash('success','Rol ingresado');
        return redirect()->route('roles');
    }

    public function eliminar(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|exists:roles,id',
            ]);
            $rol=Role::findOrFail($request->id);
            if($rol->users->count()>0){
                return response()->json(['default'=>'No se puede eliminar rol, ya que existe usuarios asignados']);
            }else{

                if($rol->name!='Administrador' && $rol->name!='Coordinador' && $rol->name!='Gestor'){
                    $rol->delete();
                    return response()->json(['success'=>'Rol eliminado']);
                    
                }else {
                    return response()->json(['default'=>'No puede eliminar este rol.']);
                }
                
            }
        } catch (\Exception $th) {
            return response()->json(['default'=>'No se puede eliminar rol']);
        }
    }
}
