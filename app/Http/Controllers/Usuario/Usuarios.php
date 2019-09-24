<?php

namespace iobom\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;

use iobom\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use iobom\Http\Requests\Usuarios\RqGuardar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use iobom\Http\Requests\Usuarios\RqActualizar;
use iobom\DataTables\Usuarios\PorRolDataTable;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use iobom\DataTables\Usuarios\UsuarioDataTable;
use iobom\Imports\UsersImport;
use iobom\Models\Estacion;

class Usuarios extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de personal operativos']);
    }

    public function index(UsuarioDataTable $dataTable)
    {
        $roles=Role::all();
        return $dataTable->render('usuario.usuarios.index',['roles'=>$roles]);
    }

    // Autor:Deivid
    // Desc:vista nuevo contacto de usuario enviamos todos los roles
    public function nuevo()
    {
        $roles=Role::all();
        $user=Auth::user();
        $estaciones=Estacion::all();
        return view('usuario.usuarios.nuevo',['roles'=>$roles,'estaciones'=>$estaciones]);
    }

    // Autor:Deivid
    // Desc:guardar nuevo usuario con roles
    public function guardar(RqGuardar $request)
    {
        $user= new User();
         $user->name = $request->name;
         $user->telefono = $request->telefono;
         $user->email = $request->email;           
         $user->password = Hash::make($request->password);
  
        $user->estacion_id=$request->estacion_id;

        $user->creadoPor=Auth::user()->id;
        $user->save();
        $user->assignRole($request->roles);
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/usuarios', $request->file('foto'), $user->id.'.'.$extension
                );
                $user->foto=$path;
                $user->save();
            }
        }
        
        $request->session()->flash('success','Personal operativo registrado exitosamente');
        return redirect()->route('usuarios');
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
        ]);
        
        try {
            DB::beginTransaction();

            $user=User::findOrFail($request->user);
            
            if(Auth::user()->id!=$user->id){
                
                if($user->delete()){
                    Storage::delete($user->foto);
                }
                
                DB::commit();
                return response()->json(['success'=>'Personal operativo eliminado exitosamente']);
                
            }else{
                return response()->json(['default'=>'No se puede autoeliminarse']);
            }
            
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar personal operativo']);
        }
    }

    // A: Deivid
    // D: Actualizar roles de usuario
    public function editarRol($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        $roles=Role::all();
        $data = array('usuario' => $user,'roles'=>$roles );
        return view('usuario.usuarios.actualizarRol',$data);
    }

    // A:Deivid
    // D: sincronizar los roles de usuarios
    public function actualizarRolUsuario(Request $request)
    {
        $request->validate([
            'usuario' => 'required|exists:users,id',
            "roles"    => "nullable|array",
            "roles.*"  => "nullable|exists:roles,id",
        ]);
        $user=User::findOrFail($request->usuario);
        $user->syncRoles($request->roles);
        $user->actualizadoPor=Auth::user()->id;
        $user->save();
        return redirect()->route('editarRolUsuario',$user->id);
    }

    // A:Deivid
    // D: Actualizar usuario
    public function editar($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        $estaciones=Estacion::all();
        return view('usuario.usuarios.editar',['usuario'=>$user,'estaciones'=>$estaciones]);
    }
    
    public function actualizar(RqActualizar $request)
    {
        $user=User::findOrFail($request->usuario);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->telefono=$request->telefono;
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        $user->estado = $request->estado;
        $user->estacion_id=$request->estacion_id;
        $user->actualizadoPor=Auth::user()->id;
        $user->save();

        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                Storage::delete($user->foto);
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/usuarios', $request->file('foto'), $user->id.'.'.$extension
                );
                $user->foto=$path;
                $user->save();
            }
        }

        $request->session()->flash('success','Personal operativo editado exitosamente');

        return redirect()->route('usuarios');
    }

    // A:Deivid
    // D:Infromacion total de usuario
    public function informacion($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        return view('usuario.usuarios.informacion',['usuario'=>$user]);
    }

    // A:Deivid
    // D:obtener usuarios por rol, se utliza la misma vista y diferente datatable
    public function usuariosPoRol(PorRolDataTable $dataTable, $nombreRol)
    {
        try {
            $role = Role::findByName($nombreRol);
            $roles=Role::all();
            return $dataTable->with('rol',$role->name)->render('usuario.usuarios.index',['roles'=>$roles]);
        } catch (\Exception $th) {
            return abort(404);
        }
    }

    //A:Deivid
    //D:Descargar infromacion de usuario a pdf
    public function informacionPdf($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        $pdf = PDF::loadView('usuario.usuarios.pdf',['usuario'=>$user]);
        return $pdf->inline();
    }

    // A:Deivid
    // D:Imprimir informaciond de usuario
    public function informacionImprimir($idUsuario)
    {
        $user=User::findOrFail($idUsuario);
        return view('usuario.usuarios.imprimir',['usuario'=>$user]);
    }

    // A:Deivid
    // D:importar usuarios
    public function importar()
    {
        return view('usuario.usuarios.importar');
    }

    public function procesarImportacion(Request $request)
    {
        Excel::import(new UsersImport, $request->file('archivo'));
        return redirect()->route('usuarios')->with('success', 'Personal operativo importados');
    }
}
