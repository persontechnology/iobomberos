@extends('layouts.app',['title'=>'Información Formularios'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
 
    <div class="card-body">
        <h4 class="text-center"><strong>DETALLE DEL FORMULARIO DE EMERGENCIA N° {{$formulario->numero}} </strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
               <tbody>
                    <tr>
                        <th colspan="2">
                            <strong> Estado: </strong> <span class="badge  badge-pill bg-teal-400">{{$formulario->estado}}</span>
                        </th>
                    </tr>
                   <tr>
                        <th colspan="2">
                            <strong>Emergencia: </strong> {{$formulario->emergencia->nombre}}
                        </th>
                   </tr>
                   <tr>
                        <th>
                            <strong>Fecha: </strong> {{$formulario->fecha}}
                        </th>
                        <th>
                            <strong>Hora de aviso del incidente: </strong> {{$formulario->horaSalida}}
                        </th>
                   </tr>
                   <tr>
                        <th>
                            <strong>Lugar del Incidente: </strong> {{$formulario->puntoReferencia->referencia??'XXXXXXXXXX'}}
                        </th>
                        <th>
                            <strong>Nombre de la Institución que informa: </strong> {{$formulario->institucion}}
                        </th>
                   </tr>
                   <tr>
                        <th>
                            <strong>Frecuencia: </strong> {{$formulario->frecuencia}}
                        </th>
                        <th>
                            <strong>Tipo de Aviso: </strong> {{$formulario->formaAviso}}
                        </th>
                   </tr>
                   <tr>
                        <th class="text-primary">
                            <strong>Creado Por: </strong> {{$formulario->creadoPorUsuario->name??''}}
                        </th>
                        <th class="text-success">
                            <strong >Creado el: </strong> {{$formulario->created_at}}
                        </th>
                   </tr>
                   <tr class="text-center">
                       <th colspan="2">
                           <h4><strong>Personal y unidades despachadas <br>
                           </strong></h4>
                           <div class="text-info">
                                <strong>Encargado Formulario: </strong>{{$formulario->asitenciaEncardado->usuario->name??'XXXXXXXXXX'}}
                            </div>
                            </th>
                   </tr>
                   
               </tbody>
            </table>
            @foreach ($formulario->estacionFormularioEmergencias as $estaciones)                      
                   
            <table class="table table-bordered">
                <tbody>
                    <tr class="text-center">
                        <th colspan="4">
                            <strong>{{$estaciones->estacion->nombre}}</strong>
                            <br>
                            <div class="text-warning">
                                <strong>Encargado de la estación: </strong>{{$estaciones->responsable->name??'XXXXXXXXXX'}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>Unidades</th>
                        <th>Operador</th>
                        <th>Acompañantes</th>
                        <th>Paramédico</th>
                    </tr>
                    @foreach ($estaciones->formularioEstacionVehiculo as $vehiculo)
                    <tr >
                        <th>
                            <strong>{{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->nombre}} <br>
                                {{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo}}
                                {{$vehiculo->asistenciaVehiculo->vehiculo->codigo}}
                            </strong>
                        </th>
                        <th>
                            <ul>
                                @if ($vehiculo->vehiculoOperador)
                                    <li>
                                        {{$vehiculo->vehiculoOperador->asistenciaPersonal->usuario->name}}  
                                    </li> 
                                @else
                                <li class="text-danger">
                                    Operador  no asignado
                                </li> 
                                @endif
                                
                            </ul>

                        </th>
                        <th>
                            <ul>
                                @foreach ($vehiculo->vehiculoOperativos as $operativos)
                                    
                                    <li>
                                        {{$operativos->asistenciaPersonal->usuario->name}}
                                    </li>
                                @endforeach
                            </ul>
                        </th>
                        <th>
                            <ul>
                                
                                    @if ($vehiculo->vehiculoParamedico)
                                        <li>
                                            {{$vehiculo->vehiculoParamedico->asistenciaPersonal->usuario->name}}   
                                        </li> 
                                    @else
                                    <li class="text-danger">
                                       Paramédico no asignado
                                    </li> 
                                    @endif
                               
                            </ul>
                        </th>

                    </tr>  
                    @endforeach
                    
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
</div>

@push('linksCabeza')
{{--  datatable  --}}
@endpush

@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuFormularios').addClass('active');
</script>
 
@endprepend

@endsection