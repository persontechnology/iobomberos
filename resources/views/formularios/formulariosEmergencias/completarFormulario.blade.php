@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <table style="border-collapse: collapse; border: none;">
            <td class="noBorder">
                    <img src="{{ asset('img/escudo.png') }}" alt="" width="75px;" style="text-align: left;">
            </td>
            <td class="noBorder">
                <h4 style="text-align: center;">
                    <strong>
                    CUERPO DE BOMBEROS DE LATACUNGA <br>
                    OPERATIVO <br>
                    </strong>
                </h4>
            </td>
            <td class="noBorder">
                
                <img src="{{ asset('img/ecuador.png') }}" alt="" width="75px;" style="text-align: right;">
            </td>
        </table>
        <p class="text-right mt-2">Latacunga, {{ $formu->fecha }}</p>
        <p>
            {{ $formu->maximaAutoridad->name }} <br>  
            
            <strong>JEFE DE CUERPO DE LATACUNGA </strong> <br>
            Presente:
        </p>
        <h3 class="text-center"><strong>INFORME N° {{ $formu->numero }} DEL EVENTO ADEVRSO</strong></h3>

    </div>
    <div class="card-body">
        <h6><strong>1.- TIPO DE EMERGENCIA</strong></h6>
        Emergencia: <strong>{{ $formu->emergencia->nombre }}</strong>
        <br>
        @if (count($formu->emergencia->tipos)>0)
        <div class="border">
            @foreach ($formu->emergencia->tipos as $tipoEme)
                <div class="form-check form-check-inline ml-1">
                    <input class="form-check-input" type="checkbox" name="tipoEmergencia" id="tipoEme_{{ $tipoEme->id }}" value="{{ $tipoEme->id }}">
                    <label class="form-check-label" for="tipoEme_{{ $tipoEme->id }}">
                        {{ $tipoEme->nombre }}
                    </label>
                </div>
            @endforeach
        </div>
        @else
            <div class="alert alert-danger" role="alert">
                <strong>Está emergencia no tiene tipos</strong>
            </div>
        @endif
        <h6 class="mt-1"><strong>2.- INFORMACIÓN GENERAL.</strong></h6>
        <div class="border">
            Fecha: <strong>{{\Carbon\Carbon::parse($formu->fecha)->format('d/m/Y')  }}</strong>  Hora de aviso del incidente: <strong>{{ $formu->horaSalida }} </strong>
            Hora de salida: <strong>{{ $formu->horaSalida }}</strong><br>
            Hora de Arrivo del Incidente: <strong><input type="time" name="horaEntrada" id="horaEntrada" class="" required></strong> Lugar de Incidente:  
            <strong> 
                @if ($formu->puntoReferencia_id)
                {{$formu->puntoReferencia->barrio->nombre.'-'.$formu->puntoReferencia->referencia}}
                @else
                    {{$formu->localidad}}
                @endif
            </strong>
            Nombre o Institución que Informa: <strong>{{ $formu->institucion}}</strong> <br>
            
            Aviso del evento: <strong>{{ $formu->responsable->hasRole('Radio operador')?'Radio operador':'Personal de guardia' }}</strong>

            <div class="form-check form-check-inline ml-1">
                <label class="form-check-label" for="Teléfonico">
                        Teléfonico
                </label>
                <input class="form-check-input" type="checkbox" {{ $formu->formaAviso=="Teléfonico"?'checked':'' }} name="formaAviso" id="formaAviso" value="Teléfonico">
            </div>
            <div class="form-check form-check-inline ml-1">
                    <label class="form-check-label" for="Personal">
                            Personal
                    </label>
                    <input class="form-check-input" type="checkbox" {{ $formu->formaAviso=="Personal"?'checked':'' }} name="formaAviso" id="formaAviso" value="Personal">
                </div>

        </div>
        <h6 class="mt-1"><strong>3.- PERSONAL Y UNIDADES DESPACHADAS.</strong></h6>

        @foreach ($formu->estacionFormularioEmergencias as $estaciones)                      
                   
            <table class="table-bordered">
                <tbody>
                    <tr class="text-center">
                        <th colspan="4">
                            <strong>{{$estaciones->estacion->nombre}}</strong>
                            
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
        <br>
        
        @can('comprobarContraIncendio', $formu)
        <h6 class="mt-1"><strong>4.- ETAPAS DE INCENDIO Y EDIFICACIÓN.</strong></h6>
        <div class="border">
            
            
            <table class="table-border text-center">
                <tr>
                    <th colspan="6">
                            <h6 class="mt-1"><strong> ETAPAS DE INCENDIO.</strong></h6>
                    </th>
                </tr>
                <tr>
                    <th>
                        Incipiente
                        <input class="mt-1" type="checkbox"  name="" id="">
                    </th>
                    <th>
                        Desarrollo
                        <input class="mt-1" type="checkbox"  name="" id="">

                    <th>
                        Combustión libre
                        <input class="mt-1" type="checkbox"  name="" id="">
  
                    <th>
                        Flashover
                        <input class="mt-1" type="checkbox"  name="" id="">
  
                    <th>
                        Decadencia
                        <input class="mt-1" type="checkbox"  name="" id="">

                    <th>
                        Arder sin llama
                        <input class="mt-1" type="checkbox"  name="" id="">
                    </th>
                       

                </tr>
            </table>
            <br>
            <table class="table-border text-center">
                    <tr>
                        <th colspan="6">
                                <h6 class="mt-1"><strong> EDIFICACIÓN.</strong></h6>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Tipo de construción    
                        </th>
                        <th>
                            Madera
                            <input class="mt-1" type="checkbox"  name="" id="">
                        </th>
                        <th>
                            Hormigón
                            <input class="mt-1" type="checkbox"  name="" id="">
                        </th>
                        <th>
                            Mixta
                            <input class="mt-1" type="checkbox"  name="" id="">
                        </th>
                        <th>
                            Metálica
                            <input class="mt-1" type="checkbox"  name="" id="">
                        </th>
                        <th>
                            Adobe
                            <input class="mt-1" type="checkbox"  name="" id="">
                        </th>                          
    
                    </tr>

                    <tr>
                            <th>
                                Númerp de plantas  
                            </th>
                            <th>
                                Planta baja
                                <input class="mt-1" type="checkbox"  name="" id="">
                            </th>
                            <th>
                                1 Planta
                                <input class="mt-1" type="checkbox"  name="" id="">
                            </th>
                            <th>
                                2 Planta
                                <input class="mt-1" type="checkbox"  name="" id="">
                            </th>
                            <th>
                                3 Planta
                                <input class="mt-1" type="checkbox"  name="" id="">
                            </th>
                            <th>
                                Patio
                                <input class="mt-1" type="checkbox"  name="" id="">
                            </th>                          
        
                        </tr>
                </table>          
        </div>
         
        @endcan
        
        @can('comprobarAtensionHospitalaria', $formu)
            <button class="btn btn-primary"> Crear fichas medica</button>
        @elsecan('noPreospitalario', $formu)
        <h6 class="mt-1"><strong>5.- ORIGEN Y CAUSAS DEL EVENTO.</strong></h6>
        <textarea class="form-control" name="" id="" cols="20" rows="5"></textarea>
        <h6 class="mt-1"><strong>6.- TRABAJO REALIZADO.</strong></h6>  
        <textarea class="form-control" name="" id="" cols="20" rows="10"></textarea>
        <h6 class="mt-1"><strong>7.- RECURSOS UTILIZADOS.</strong></h6>
        <ul class="">
            <li>

            </li>
        </ul>
        @endcan
    </div>
    <div class="card-footer text-muted">
        Footer
    </div>
</div>




@push('linksCabeza')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    
    table, th, td {
    border: 1px solid black;
    }
    .noBorder {
        border:none !important;
    }
    .iz {
        text-align: right;
      }
</style>
@endpush

@prepend('linksPie')
    <script>
        
        $('#menuEscritorio').addClass('active');

        // cargara personal y unidades despachadas --> paso 3
        
        $("#cargarPersonalUnidades").load("{{ route('cargarPersonalUnidadesDespachadas',$formu->id) }}", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                console.log('ok')
            }
              
            if(statusTxt == "error"){
                notificar('error','NO se pudo cargar personal y unidades depachadas');
            }
            
          });
         
    </script>
    
    

@endprepend
@endsection
