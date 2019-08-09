<?php

namespace iobom\Http\Controllers\Emergencias;

use Illuminate\Http\Request;
use iobom\Http\Controllers\Controller;
use iobom\DataTables\Emergencias\EmergenciaDataTable;
use iobom\Models\Emergencia\Emergencia;
use Illuminate\Support\Facades\Auth;

class Emergencias extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:G. de emergencia']);
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
        return redirect()->route('emergencia')->with('success','Emergencia registrado exitosamente');
    }
}
