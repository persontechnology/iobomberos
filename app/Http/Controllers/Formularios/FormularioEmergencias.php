<?php

namespace iobom\Http\Controllers\formularios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use iobom\DataTables\Formularios\FormularioEmergenciasDataTable;
use iobom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use iobom\Http\Requests\FormularioEmergencia\RqIngreso;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Asistencia\AsistenciaPersonal;
use iobom\Models\Asistencia\AsistenciaVehiculo;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Models\FormularioEmergencia\Danio;
use iobom\Models\FormularioEmergencia\Edificacion;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\FormularioEmergencia\EtapaIncendio;
use iobom\Models\FormularioEmergencia\Anexo;
use iobom\Models\FormularioEmergencia\FormularioEstacionVehiculo;
use iobom\Models\FormularioEmergencia\Material;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;
use iobom\Models\Vehiculo;
use iobom\User;
use iobom\Models\FormularioEmergencia\VehiculoOperador;
use iobom\Models\FormularioEmergencia\VehiculoOperativo;
use iobom\Models\FormularioEmergencia\VehiculoParamedico;
use iobom\Notifications\NoticarEncargadoNuevoFormulario;

class FormularioEmergencias extends Controller
{
    
    public function index(FormularioEmergenciasDataTable $dataTable)
    {
        return  $dataTable->render('formularios.formulariosEmergencias.index');
    }
    
    public function nuevo( )
    {
        $this->authorize('crearNuevoFormularioEmergencia', Auth::user());   
        
        $emergencias=Emergencia::get();
        $puntoReferencias=PuntoReferencia::get();
        $parroquias=Parroquia::get();
        $estacines=Estacion::get();
        //buscar usuario que esten el la lista 
        $diaHoy=Carbon::now();
        $sumarUnDia=$diaHoy->addDays(1);
        $fechaMenor=$diaHoy->setDateTime($sumarUnDia->year,$sumarUnDia->month,$sumarUnDia->day,7,30,0,0)->toDateTimeString();
        
        $asistenciaHoy=Asistencia::where('fecha',Carbon::now()->toDateString())
        ->where('fechaFin','<=',$fechaMenor)->get();

        $astenciaPersonal=AsistenciaPersonal::
        whereIn('asistencia_id',$asistenciaHoy->pluck('id'))->get();

        $user = User::whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');
        })->get();

        $asistenciaHoyFitro=$astenciaPersonal->whereIn('user_id',$user->pluck('id'));      
        //fin de la busqueda de usuarios
        $numero=FormularioEmergencia::latest()->value('numero');
        if($numero){
            $numero=$numero+1;
        }else{
            $numero=1;
        }
        
        $data = array(
            'emergencias' => $emergencias,
            'puntoReferencias'=>$puntoReferencias,
            'estaciones'=>$estacines, 
            'parroquias'=>$parroquias,
            'asistenciaHoy'=> $asistenciaHoyFitro, 
            'numero'=>$numero,      
        );

        return view('formularios.formulariosEmergencias.nuevo',$data);
        
    }

    public function buscarPuntoReferenciaId(Request $request)
    {
        $puntoReferencia=PuntoReferencia::findOrFail($request->id);
        if($puntoReferencia){
            return response()->json($puntoReferencia);
        }else{
            return response()->json(['data'=>'error']);
        }
    }

    public function guardarFormulario(RqIngreso $request)
    {
        $this->authorize('crearNuevoFormularioEmergencia', Auth::user()); 
        
        try {
            DB::beginTransaction();
            $numero=FormularioEmergencia::latest()->value('numero');
            if($numero){
                $numero=$numero+1;
            }else{
                $numero=1;
            }
            
            $form=new FormularioEmergencia();
            $form->numero=$numero;
            $form->fecha=Carbon::now();
            $form->horaSalida=Carbon::now()->toTimeString();

            $form->institucion=$request->institucion;
            $form->telefono=$request->telefono;
            $form->formaAviso=$request->formaAviso;;
            $form->estado='Asignado';
            $form->frecuencia=$request->frecuencia;
            $form->puntoReferencia_id=$request->puntoReferencia;
            $form->localidad=$request->direcionAdicional;

            // maxima autoridad
            $maximaAutoridad = User::role('Máxima autoridad')->first();
            $form->maximaAutoridad_id=$maximaAutoridad->id??null;
            $form->emergencia_id=$request->emergencia;
            $form->creadoPor=Auth::id();
            
            $form->save();
            //actualizar encargado del formulario
            $encargadoFormulario=FormularioEmergencia::findOrFail($form->id);
            $encargadoFormulario->encardadoFicha_id=$request->encargadoFormulario;
            $encargadoFormulario->save();

            // A:deivid
            // D: enviar notificacion por email al encargado del formulario
            $encargadoFormulario->asitenciaEncardado->usuario->notify(new NoticarEncargadoNuevoFormulario() );


            // crear formulario y los vehiculos asignados
            $i=0;
            foreach ($request->vehiculos as $vehiculos) {
                //Buscar asistencia del vehiculo en el dia
                $asistenciaVehiculo=AsistenciaVehiculo::findOrFail($vehiculos);
                //buscar si existe una estacion de formulario de emergencia 
                $estacionFOrmulara=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                ->where('formularioEmergencia_id',$form->id)
                ->count();
                $estacionFormularioEmergencia=new EstacionFormularioEmergencia();
                $formularioEstacionVehiculo=new FormularioEstacionVehiculo();                              
                
                //verifiacar si la estacion ya esta registrada
                if($estacionFOrmulara==0){
                    //guardar la estacion a quien pertence el vehiculo
                    $estacionFormularioEmergencia->estacion_id=$asistenciaVehiculo->vehiculo->estacion_id;
                    $estacionFormularioEmergencia->formularioEmergencia_id=$form->id;                    
                    $estacionFormularioEmergencia->save();
                    //guardar vehiculo en cada uno de las estaciones
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularioEmergencia->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                  
                    $formularioEstacionVehiculo->save();
                    //buscar estacion del formulario
                    $buscarestacionEstacion=EstacionFormularioEmergencia::findOrFail($estacionFormularioEmergencia->id);
                        foreach($request->encargadoEstacion as $encargadoEstacion){
                            $variableAuxEnca=explode('-',$encargadoEstacion);
                            if($buscarestacionEstacion->estacion_id==$variableAuxEnca[0]){
                                $asistenciaPersonalEstacion=AsistenciaPersonal::findOrFail($variableAuxEnca[1]);             
                                $buscarestacionEstacion->user_id= $asistenciaPersonalEstacion->user_id;
                                $buscarestacionEstacion->save();
                                $asistenciaPersonalEstacion->estadoEmergencia='Emergencia';
                                $asistenciaPersonalEstacion->save();
                            }
                        }
                        
                    
                }else{
                    //Buscar si la estacion existe en la asignacion del formulario 
                    $estacionFormularaPrimero=EstacionFormularioEmergencia::where('estacion_id',$asistenciaVehiculo->vehiculo->estacion_id)
                    ->where('formularioEmergencia_id',$form->id)->first();
                    //guardar la estacion a quien pertence el vehiculo
                    $formularioEstacionVehiculo->estacionForEmergencias_id=$estacionFormularaPrimero->id;
                    $formularioEstacionVehiculo->asistenciaVehiculo_id=$asistenciaVehiculo->id;                 
                    $formularioEstacionVehiculo->save();                    
                 
                }
                //guardar operador en cada veiculo registrado
                if($request->operador[$i]){
                $vehiculoOperador=new VehiculoOperador();  
                $vehiculoOperador->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                $vehiculoOperador->asistenciaPersonal_id=$request->operador[$i];
                $vehiculoOperador->save();
                }
                //guardar Acompañantes en cada vehiculo
                foreach ($request->operativos as $operativo ) {
                    $variableAux=explode('-',$operativo);
                     if($variableAux[0]==$asistenciaVehiculo->id){
                        $personalOperacional=new VehiculoOperativo();                                           
                        $personalOperacional->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                        $personalOperacional->asistenciaPersonal_id=$variableAux[1];
                        $personalOperacional->save();
                        //cambiar estado al personal
                        $asistenciaPersonal=AsistenciaPersonal::findOrFail($variableAux[1]);
                        $asistenciaPersonal->estadoEmergencia='Emergencia';
                        $asistenciaPersonal->save();                         
                     }
                }
                //guardar Paramedico
                
                if($request->paramedico[$i]){
                    $vehiculoParamedico=new VehiculoParamedico();  
                    $vehiculoParamedico->estacionForVehiculo_id=$formularioEstacionVehiculo->id;
                    $vehiculoParamedico->asistenciaPersonal_id=$request->paramedico[$i];
                    $vehiculoParamedico->save();
                    $personalParamedico=AsistenciaPersonal::where('id',$request->paramedico[$i])->first();
                    $personalParamedico->estadoEMergencia="Emergencia";
                    $personalParamedico->save();
                }
                // cambiar de estado al vehiculo 
                $asistenciaVehiculo->estadoEMergencia="Emergencia";
                $asistenciaVehiculo->save();
                // cambiar de estado del operador asignado a la emergencia
                $personalOperado=AsistenciaPersonal::where('id',$request->operador[$i])->first();
                $personalOperado->estadoEMergencia="Emergencia";
                $personalOperado->save();
                $i++;
            }
            DB::commit();
            $request->flash('success','Formulario # '.$form->numero.' registrado exitosamente');
        } catch (\Exception $th) {
            DB::rollback();
            $request->session()->flash('danger','Ocurrio un error, vuelva intentar');
        }
        return redirect()->route('formularios');
    }
    
    public function completarFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $data = array('formu' => $formulario );
        return view('formularios.formulariosEmergencias.completarFormulario',$data);

    }

    public function cargarPersonalUnidadesDespachadas($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $estacionsSi=$formulario->estaciones;
        $estacionsNo=Estacion::whereNotIn('id',$formulario->estaciones->pluck('id'))->get();
        $data = array('formu' => $formulario,'estacionesSi'=>$estacionsSi,'estacionesNo'=>$estacionsNo );
        return view('formularios.formulariosEmergencias.cargarPersonalUnidadesDespachadas',$data);
    }

    public function cerarEtapasIncendiEdificacion(Request $request)
    {
        $formulario=FormularioEmergencia::findOrFail($request->formulario);
        if($formulario->etpaIncendio && $formulario->edificacion){
            return response(['success'=>'existe']);
        }else{
            $etapa=new EtapaIncendio();
            $etapa->formularioEmergencia_id=$formulario->id;
            $etapa->save();
            $edificacion=new Edificacion();
            $edificacion->formularioEmergencia_id=$formulario->id;
            $edificacion->save();
            return response(['success'=>'ok']);
        }
        
    }
    public function buscarPersonalOperador(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesAscendente()
        ->whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push( $data,$usuario->getRoleNames()->first().'--'.$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }
    public function buscarPersonalOperativo(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesDescendente()
        ->whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push( $data,$usuario->getRoleNames()->first().'--'.$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }

    public function buscarPersonalParamedico(Request $request)
    {
        $vehiculo=Vehiculo::findOrFail($request->vehiculo);
        // $vehiculo=Vehiculo::findOrFail($idVe);
        $estacion=Estacion::findOrFail($vehiculo->estacion_id);
        $usuarios=$estacion->asistenciaHoy->asietenciaAsistenciaPersonalesAscendente()
        ->whereHas('roles', function($q){
            $q->where('name', 'Paramédico');

        })->get();
        $data = array();       
        foreach ($usuarios as $usuario) {
            
            array_push($data ,$usuario->name.'--'.$usuario->asistenciaPersonal->id);
        }   
        // return $data;
        return response()->json($data);
    
    }
    public function informacionFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        // $user=User::findOrFail($formulario->cread)
        $data = array('formulario' => $formulario, );
        return view('formularios.formulariosEmergencias.informacion',$data);
    }

    public function editarFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $this->authorize('editarFormulario', $formulario); 
        $emergencias=Emergencia::get();
        $puntoReferencias=PuntoReferencia::get();
        $parroquias=Parroquia::get();
        $estacines=Estacion::get();
        //buscar usuario que esten el la lista 
        $diaHoy=Carbon::now();
        $sumarUnDia=$diaHoy->addDays(1);
        $fechaMenor=$diaHoy->setDateTime($sumarUnDia->year,$sumarUnDia->month,$sumarUnDia->day,7,30,0,0)->toDateTimeString();
        
        $asistenciaHoy=Asistencia::where('fecha',Carbon::now()->toDateString())
        ->where('fechaFin','<=',$fechaMenor)->get();

        $astenciaPersonal=AsistenciaPersonal::
        whereIn('asistencia_id',$asistenciaHoy->pluck('id'))->get();

        $user = User::whereHas('roles', function($q){
            $q->where('name','!=', 'Administrador');
        })->get();

        $asistenciaHoyFitro=$astenciaPersonal->whereIn('user_id',$user->pluck('id'));      
       
        $data = array(
            'emergencias' => $emergencias,
            'puntoReferencias'=>$puntoReferencias,
            'estaciones'=>$estacines, 
            'parroquias'=>$parroquias,
            'asistenciaHoy'=> $asistenciaHoyFitro, 
            
            'formulario'=>$formulario,      
        );
        
        return view('formularios.formulariosEmergencias.editar',$data); 
    }

    public function misFormularios()
    {

        $asistenciaPersonal=AsistenciaPersonal::where('user_id',Auth::id())->get();
        $formulariosAsignados=FormularioEmergencia::where('estado','Proceso')
        ->whereIn('encardadoFicha_id',$asistenciaPersonal->pluck('id'))
        ->get();
        
        $formulariosFinalizados=FormularioEmergencia::where('estado','Finalizado')
        ->whereIn('encardadoFicha_id',$asistenciaPersonal->pluck('id'))
        ->get();
        
        $data = array('formulariosAsignados' =>$formulariosAsignados, 
                    'formulariosFinalizados'=>$formulariosFinalizados, );
        // return $formularios;
        return view('formularios.formulariosEmergencias.misFormularios',$data); 
    }
    public function proceso($idFormulario)
    {
        
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $this->authorize('misFormularios', $formulario); 
        $data = array('formu' =>$formulario );
        return view('formularios.formulariosEmergencias.completarFormulario',$data); 
    }
    //gfuncion para completar los materiales que se utilizarn dentro de un formulrio
    public function materialesFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $data = array('formulario' =>$formulario );
        return view('formularios.materiales.index',$data); 
    }
    public function guardarMateriales(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191',
            'formulario' => 'required|exists:formularioEmergencia,id',
        ]);
        $materiales=new Material();
        $materiales->nombre=$request->nombre;
        $materiales->formularioEmergencia_id=$request->formulario;
        $materiales->save();
    }
    public function eliminarMaterial(Request $request)
    {        
        $request->validate([
            'material'=>'required|exists:materials,id',
        ]);
        try {
            DB::beginTransaction();
            $material=Material::findOrFail($request->material);
            $material->delete();
            DB::commit();
            return response()->json(['success'=>'Material eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el material']);
        }
        
    }

    //funcion para completar los materiales que se utilizarn dentro de un formulrio
    public function daniosFormulario($idFormulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idFormulario);
        $data = array('formulario' =>$formulario );
        return view('formularios.danios.index',$data); 
    }
    public function guardarDanios(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:191',
            'idFormulario' => 'required|exists:formularioEmergencia,id',
        ]);
        $danio=new Danio();
        $danio->nombre=$request->nombre;
        $danio->formularioEmergencia_id=$request->idFormulario;
        $danio->save();
    }
    public function eliminarDanio(Request $request)
    {        
        $request->validate([
            'danio'=>'required|exists:danios,id',
        ]);
        try {
            DB::beginTransaction();
            $danio=Danio::findOrFail($request->danio);
            $danio->delete();
            DB::commit();
            return response()->json(['success'=>'Daño ocasional eliminada exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el daño ocasional']);
        }
        
    }
    public function completarFormularioResposable(Request $request)
    {    $request->validate([            
            'formulario' => 'required|exists:formularioEmergencia,id',
            'tipoEmergencia'=>'required|exists:tipoEmergencia,id',
            'horaEntrada'=>'required',
            'origenCausa'=>'min:150|string',
            'numeroHeridos'=>'integer'
        ]);
        $formulario=FormularioEmergencia::findOrFail($request->formulario);
        $diaHoy=Carbon::now();
        
        try {
            DB::beginTransaction();
            $formulario->tipoEmergencia_id=$request->tipoEmergencia;
            $formulario->horaEntrada=$request->horaEntrada;
            $formulario->origenCausa=$request->origenCausa;
            $formulario->tabajoRealizado=$request->tabajoRealizado;
            if($request->numeroHeridos){
                $formulario->heridos=$request->numeroHeridos;
            }
            $formulario->actualizadoPor=Auth::id();
            $formulario->save();
            //ingresar etapas de incendio
            if($formulario->etapaIncendio){
                $etapaIncendio=EtapaIncendio::findOrFail($formulario->etapaIncendio->id);
                $etapaIncendio->incipiente=$this->conversioCheckbox($request->incipiente);
                $etapaIncendio->desarrollo=$this->conversioCheckbox($request->desarrollo);
                $etapaIncendio->combustion=$this->conversioCheckbox($request->combustion);
                $etapaIncendio->flashover=$this->conversioCheckbox($request->flashover);
                $etapaIncendio->decadencia=$this->conversioCheckbox($request->decadencia);
                $etapaIncendio->arder=$this->conversioCheckbox($request->arder);
                $etapaIncendio->save();

            }else{
                $etapaIncendioNuevo=new EtapaIncendio();
                $etapaIncendioNuevo->formularioEmergencia_id=$formulario->id;
                $etapaIncendioNuevo->incipiente=$this->conversioCheckbox($request->incipiente);
                $etapaIncendioNuevo->desarrollo=$this->conversioCheckbox($request->desarrollo);
                $etapaIncendioNuevo->combustion=$this->conversioCheckbox($request->combustion);
                $etapaIncendioNuevo->flashover=$this->conversioCheckbox($request->flashover);
                $etapaIncendioNuevo->decadencia=$this->conversioCheckbox($request->decadencia);
                $etapaIncendioNuevo->arder=$this->conversioCheckbox($request->arder);
                $etapaIncendioNuevo->save();
            }
            //registro de edificacion
            if($formulario->edificacion){
                $edificacion=Edificacion::findOrFail($formulario->edificacion->id);;
                $edificacion->formularioEmergencia_id=$formulario->id;
                $edificacion->madera=$this->conversioCheckbox($request->madera);
                $edificacion->hormigon=$this->conversioCheckbox($request->hormigon);
                $edificacion->mixta=$this->conversioCheckbox($request->mixta);
                $edificacion->metalica=$this->conversioCheckbox($request->metalica);
                $edificacion->adobe=$this->conversioCheckbox($request->adobe);
                $edificacion->plantaBaja=$this->conversioCheckbox($request->plantaBaja);
                $edificacion->primerPiso=$this->conversioCheckbox($request->primerPiso);
                $edificacion->segundoPiso=$this->conversioCheckbox($request->segundoPiso);
                $edificacion->tercerPiso=$this->conversioCheckbox($request->tercerPiso);
                $edificacion->patio=$this->conversioCheckbox($request->patio);
                $edificacion->save();  
            }else{
                $edificacion=new Edificacion();
                $edificacion->formularioEmergencia_id=$formulario->id;
                $edificacion->madera=$this->conversioCheckbox($request->madera);
                $edificacion->hormigon=$this->conversioCheckbox($request->hormigon);
                $edificacion->mixta=$this->conversioCheckbox($request->mixta);
                $edificacion->metalica=$this->conversioCheckbox($request->metalica);
                $edificacion->adobe=$this->conversioCheckbox($request->adobe);
                $edificacion->plantaBaja=$this->conversioCheckbox($request->plantaBaja);
                $edificacion->primerPiso=$this->conversioCheckbox($request->primerPiso);
                $edificacion->segundoPiso=$this->conversioCheckbox($request->segundoPiso);
                $edificacion->tercerPiso=$this->conversioCheckbox($request->tercerPiso);
                $edificacion->patio=$this->conversioCheckbox($request->patio);
                $edificacion->save();
            }
            //Subir imagenes
            if ($request->hasFile('foto')) {
                $i=0;
                foreach ($request->file('foto') as $imagen) {
                    
                    if ($imagen->isValid()) {
                        $anexos=new Anexo();
                        $extension =$imagen->extension();
                        $path = Storage::putFileAs(
                            'public/anexos', $imagen,$diaHoy->format('Y/m/d H:i:s').$i.'_'.$formulario->id.'.'.$extension
                        );
                        $anexos->formularioEmergencia_id=$formulario->id;
                        $anexos->foto=$path;
                        $anexos->save();
                    }
                    $i++;
                }
            }

            DB::commit();
            $request->session()->flash('success','Formulario completado exitosamente ');
            
        } catch (\Exception $th) {
            DB::rollBack();
            echo $th;
            // $request->session()->flash('warning','no se puede completar el formulario verifique los datos y vuelva a intentar '.$th);
        }
        // return redirect()->route('proceso-formulario',$formulario->id);
        
    }
   public function cambiarEstadoProceso(Request $request)
   {
    $request->validate([            
        'formulario' => 'required|exists:formularioEmergencia,id',        
    ]);
    try {
        DB::beginTransaction();
            $formulario=FormularioEmergencia::findOrFail($request->formulario);
            $formulario->estado='Proceso';
            $formulario->save();
            foreach ($formulario->estacionFormularioEmergencias as $estacione) {
                foreach ($estacione->formularioEstacionVehiculo as $vehiculo) {
                    $asistenciaVehiculo=AsistenciaVehiculo::findOrFail($vehiculo->asistenciaVehiculo_id);
                    $asistenciaVehiculo->estadoEmergencia='Disponible';
                    $asistenciaVehiculo->save();
                    if($vehiculo->vehiculoOperador){
                        $asistenciaPersonal=AsistenciaPersonal::findOrFail($vehiculo->vehiculoOperador->asistenciaPersonal_id);
                        $asistenciaPersonal->estadoEmergencia='Disponible';
                        $asistenciaPersonal->save();
                    }
                    if($vehiculo->vehiculoOperativos->count()>0){
                        foreach ($vehiculo->vehiculoOperativos as $vehiculoOperativo) {
                            
                            $asistenciaPersonaloperativos=AsistenciaPersonal::findOrFail($vehiculoOperativo->asistenciaPersonal_id);
                            $asistenciaPersonaloperativos->estadoEmergencia='Disponible';
                            $asistenciaPersonaloperativos->save();
                        }
                    }
                    if($vehiculo->vehiculoParamedico){
                        $asistenciaPersonalParamedico=AsistenciaPersonal::findOrFail($vehiculo->vehiculoParamedico->asistenciaPersonal_id);
                        $asistenciaPersonalParamedico->estadoEmergencia='Disponible';
                        $asistenciaPersonalParamedico->save();
                                    
                    }
                }
            }
            DB::commit();
            return response()->json(['success'=>'El cambio de estado del formulario fue exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede cambiar de estado']);
        }
   }
   public function conversioCheckbox($var)
   {
       if($var==1||$var=='on'){
           return 1;
       }else{
        return 0;
       }
   }
    //anexos
    public function cargarAnexos($idformulario)
    {
        $formulario=FormularioEmergencia::findOrFail($idformulario);
        $data = array('formulario' =>$formulario);
        return view('formularios.anexos.index',$data);
    }
   //funcion para eliminar las images
   public function eliminarAnexo(Request $request)
    {        
        $request->validate([
            'anexo'=>'required|exists:anexos,id',
        ]);
        try {
            DB::beginTransaction();
            $anexo=Anexo::findOrFail($request->anexo);
            $anexo->delete();
            DB::commit();
            return response()->json(['success'=>'Anexo eliminado exitosamente']);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['default'=>'No se puede eliminar el anexo']);
        }
        
    }
}
