<?php

namespace iobom\Http\Controllers\Formularios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use iobom\Http\Controllers\Controller;
use iobom\Http\Requests\AtencionPrehospitalarias\RqIngreso;
use iobom\Models\Clinica;
use iobom\Models\Descargo\Insumo;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\AtencionInsumo;
use iobom\Models\FormularioEmergencia\AtencionPrehospitalaria;

class AtencionPrehospitalarias extends Controller
{
    public function index($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $data = array('formulario' => $formulario);
        return view('formularios.atencionPrehospitalarias.index',$data);
    }
    public function nuevo($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $clinicas=Clinica::get();
        $insumos=Insumo::get();
        $data = array('formulario' => $formulario,'clinicas'=>$clinicas,'insumos'=>$insumos);
        return view('formularios.atencionPrehospitalarias.nuevo',$data);

    }
    public function guardarAtencion(RqIngreso $request)
    {
        try {
            DB::beginTransaction();
            $atencion=new AtencionPrehospitalaria();
            $atencion->numero=$request->numero;
            $atencion->ambulancia=$request->ambulancia;
            $atencion->nombres=$request->nombres;
            $atencion->cedula=$request->cedula;
            $atencion->edad=$request->edad;
            $atencion->sexo=$request->sexo;
            $atencion->horaAtencion=$request->horaAtencion;
            $atencion->placa=$request->placa;
            $atencion->diagnostico=$request->diagnostico;
            $atencion->pulso=$request->pulso;
            $atencion->temperatura=$request->temperatura;
            $atencion->presion=$request->presion;
            $atencion->sp=$request->sp;
            $atencion->glasgow=$request->glasgow;
            $atencion->reaccionDerecha=$request->reaccionDerecha;
            $atencion->dilatacionDerecha=$request->dilatacionDerecha;
            $atencion->reaccionIzquierda=$request->reaccionIzquierda;
            $atencion->dilatacionIzquierda=$request->dilatacionIzquierda;
            $atencion->formularioEmergencia_id=$request->formulario;                     
            $atencion->clinica_id=$request->clinica;
            $atencion->resposableRecibe=$request->resposableRecibe;
            $atencion->horaEntrada=$request->horaEntrada;
            $atencion->tipoTransporte=$request->tipoTransporte;
            $atencion->motivo=$request->motivo;
            $atencion->nombresDescargo=$request->nombresDescargo;
            $atencion->cedulaDescargo=$request->cedulaDescargo;
            $atencion->creadoPor=Auth::id();
            $atencion->save();
            $i=0;
            foreach ($request->medicamentos as $medicamento) {
                if($request->cantidades[$i]>0){ 
                    $atencionInsumos=new AtencionInsumo();
                    $atencionInsumos->medicamento_id=$medicamento;
                    $atencionInsumos->atencionPrehos_id=$atencion->id;
                    $atencionInsumos->cantidad=$request->cantidades[$i];
                    $atencionInsumos->save();           
                }
                $i++;
            }
            DB::commit();
            $request->session()->flash('success','Registro Pre-Hospitalario registrada exitosamente ');
            return redirect()->route('formularios');
         } catch (\Exception $th) {
            DB::rollback();
            $request->session()->flash('danger','Ocurrio un error, vuelva intentar');
            return redirect()->route('formularios');        
           
        }
        
    }
    
    function editarAtencion($idAtencion)
    {
        $atencion=AtencionPrehospitalaria::findOrFail($idAtencion);
        $clinicas=Clinica::get();
        $insumos=Insumo::get();
        $data = array('atencion' => $atencion,'clinicas'=>$clinicas,'insumos'=>$insumos);
        return view('formularios.atencionPrehospitalarias.editar',$data);
    }
}
