<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use iobom\Models\Estacion;
use Illuminate\Support\Facades\Auth;
use iobom\DataTables\EstacionDataTable;
use iobom\Http\Requests\Estaciones\RqCrear;
use iobom\Http\Requests\Estaciones\RqEditar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use iobom\User;

class Estaciones extends Controller
{
	public function __construct()
    {
        $this->middleware(['auth','permission:G. de estaciones']);
    }

	public function index(EstacionDataTable $dataTable)
	{
		return  $dataTable->render('estaciones.index');	 	
	}
	public function nueva()
	{
		return view('estaciones.nuevo');
	}
	public function guardar(RqCrear $request)
	{		
        $estacion= new Estacion;
        $estacion->nombre=$request->nombre;
        $estacion->direccion=$request->direccion;
        $estacion->latitud=$request->latitud;
        $estacion->longitud=$request->longitud;
        $estacion->creadoPor=Auth::id();
        $estacion->save();
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/estaciones', $request->file('foto'), $estacion->id.'.'.$extension
                );
                $estacion->foto=$path;
                $estacion->save();
            }
        }


        $request->session()->flash('success','Estacíon registrada exitosamente ');
        return redirect()->route('estaciones');
	}
	public function editar($idEstacion)
	{
		$estacion=Estacion::findOrFail($idEstacion);
		return view('estaciones.editar',['estacion'=>$estacion]);
	}
	public function actualizar(RqEditar $request)
	{
		$estacion= Estacion::findOrFail($request->estacion);
        $estacion->nombre=$request->nombre;
        $estacion->direccion=$request->direccion;
        $estacion->latitud=$request->latitud;
        $estacion->longitud=$request->longitud;
        $estacion->actualizadoPor=Auth::id();
        
        $estacion->save();
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                Storage::delete($estacion->foto);
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/estaciones', $request->file('foto'), $estacion->id.'.'.$extension
                );
                $estacion->foto=$path;
                $estacion->save();
            }
        }

        $request->session()->flash('success','Estacíon editada exitosamente ');
        return redirect()->route('estaciones');
	}

    public function eliminar(Request $request)
    {
        $request->validate([
            'estacion'=>'required|exists:estacion,id',
        ]);

        try {
            DB::beginTransaction();
            $estacion=Estacion::findOrFail($request->estacion);
            $foto=$estacion->foto;
            if($estacion->delete()){
                Storage::delete($foto);
            }
            DB::commit();
            return response()->json(['success'=>'Estación eliminada exitosamente']);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar la estación']);
        }
    }


    public function cambioPersonal()
    {
        $estaciones=Estacion::all();       
        $data = array('estaciones' => $estaciones );
        return view('estaciones.cambioPersonal',$data);
    }

    public function cargaListado()
    {

        $estaciones=Estacion::all();
        $usuarios=User::where('estado',"Activo")->get();
        $data = array('estaciones' => $estaciones,'usuarios'=>$usuarios );
        return view('estaciones.lista',$data);
    }

    public function actualizarPersonalEstacion(Request $request)
    {
        $request->validate([
            'estacion' => 'required|exists:estacion,id',
            'user' => 'required|exists:users,id',
        ]);
        $user=User::findOrFail($request->user);
        $estacion=Estacion::findOrFail($request->estacion);
        $user->estacion_id=$estacion->id;
        $user->save();
        return  response()->json(['success'=>'Actualizado exitosamente']);
    }
}
