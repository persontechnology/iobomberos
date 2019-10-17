<?php

namespace iobom\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function miPerfil()
    {
        $usuario=Auth::user();
        return view('auth.perfil',compact('usuario'));
    }
    public function miPerfilActualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'password' => 'nullable|string|min:8|confirmed',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user=Auth::user();
        $user->name=$request->name;
        if($request->password){
            $user->password=Hash::make($request->password);
        }
        $user->actualizadoPor=Auth::user()->id;
        $user->save();

        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                Storage::disk('public')->delete('usuarios/'.$user->foto);
                $extension = $request->foto->extension();
                $path = Storage::putFileAs(
                    'public/usuarios', $request->file('foto'), $user->id.'.'.$extension
                );
                $user->foto=$path;
                $user->save();
            }
        }

        $request->session()->flash('success','Perfil actualizado exitosamente');

        return redirect()->route('miPerfil');
    }
}
