@extends('layouts.app',['title'=>'Información Formularios'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
    <div class="card-header">       
        <label class="center"  for="nombre">Detalles de formulario</label>         
    </div>
    <div class="card-body">
        <h4 class="text-center"><strong>INFORME N° {{$formulario->numero}} DEL EVENTO ADVERSO</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
               <tbody>
                   <tr>
                   <th><strong>Emeregencia: </strong> {{$formulario->emergencia->nombre}}</th>
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
                            <strong>Lugar del Incidente: </strong> {{$formulario->puntoReferencia->referencia}}
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
                       <th>Personal y unidades despachadas</th>
                   </tr>
                   
               </tbody>
            </table>
            @foreach ($formulario->estacionFormularioEmergencias as $estaciones)                      
                   
            <table class="table table-bordered">
                <tbody>
                    <tr class="text-center">
                        <th>
                            <strong>{{$estaciones->estacion->nombre}}</strong>
                        </th>
                    </tr>
                    @foreach ($estaciones->formularioEstacionVehiculo as $vehiculo)
                    <tr >
                            <th>
                                    <strong>{{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->nombre}} <br>
                                        {{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo}}
                                        {{$vehiculo->asistenciaVehiculo->vehiculo->codigo}}
                                    </strong>
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