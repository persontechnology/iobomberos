@extends('layouts.app',['title'=>'reporte'])

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Reporte</h5>
        <form action="{{ route('buscarReporte') }}" method="get">
            <div class="input-group mb-3">
                <input type="date" name="fecha" value="{{ $fecha??'' }}" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Buscar Reporte</button>
                </div>
            </div>
        </form>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($formularios->count()>0)
        <h4>Reporte de emergencias del Año <strong>{{date('Y',strtotime($fecha))}}</strong> del Mes <strong>{{date('m',strtotime($fecha))}}</strong></h4>
            <div class="table-responsive">
                <table class="" style="width: 100%">
                    <thead>
                        <tr >
                            <th style="text-align:center" colspan="4">INFORMACIÓN GENERAL</th>
                            <th style="text-align:center">CLASIFICACIÓN</th>
                            <th style="text-align:center" colspan="3">TIEMPO</th>
                            <th style="text-align:center">VICTIMAS</th>
                         
                            <th style="text-align:center">RECURSOS</th>
                        </tr>
                        <tr>
                            <th>Cod</th>
                            <th>Día</th>
                            <th>Dirección o lugar</th>
                            <th>Localidad</th>
                            <th>Tipo de EMergencia</th>
                            <th>Hora de Despacho</th>
                            <th>Hora Ingreso</th>
                            <th>Frecuencia</th>
                            <th>Total</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($formularios as $formulario)
                            
                        <tr>
                            <td>{{$formulario->numero}}</td>
                            <td>{{date('d',strtotime($formulario->fecha))}}</td>
                            <td>{{$formulario->puntoReferencia_id?$formulario->puntoReferencia->barrio->nombre.' '.$formulario->puntoReferencia->referencia:$formulario->localidad}}</td>
                            <td>{{$formulario->localidadEjecutada}}</td>
                            <td>{{$formulario->emergencia->nombre}}</td>
                            <td>{{$formulario->horaSalida}}</td>
                            <td>{{$formulario->horaEntrada}}</td>
                            <td>{{$formulario->frecuencia}}</td>
                            <td>{{$formulario->heridos}}</td>
                            <td style="text-align:left">
                                <ul>
                                @foreach ($formulario->estacionFormularioEmergencias as $estacion)
                                
                                   <li> {{ $estacion->estacion->nombre }}
                                       <br>
                                       
                                        @foreach ($estacion->formularioEstacionVehiculo as $vehiculo)
                                       
                                            <strong>
                                                {{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$vehiculo->asistenciaVehiculo->vehiculo->codigo}},
                  
                                            </strong>
                                        
                                        @endforeach
                                       </ul>
                                   </li>
                              
                                    
                                @endforeach
                            </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                No existen datos registros
            </div>
        @endif
    </div>

    
</div>
@push('linksCabeza')

@endpush

@prepend('linksPie')

<script>
   
    </script>
    <style>
        table {
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid black;
          padding: 10px;
          text-align: left;
        }
      </style>
@endprepend


@endsection