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
                            <strong>Lugar del Incidente: </strong> {{$formulario->puntoReferencia->referencia??'NO EXISTE UN PUNTO DE REFERENCIA'}}
                        </th>
                        <th>
                            <strong>Nombre de la Institución que informa: </strong> {{$formulario->institucion}}
                        </th>
                   </tr>
                   <tr>
                    <th>
                        <strong>Dirección adicional: </strong> {{ $formulario->localidad??'NO EXISTE DIRECCÍON ADICIONAL'}}
                    </th>
                    <th>
                        <strong>Teléfono: </strong> {{  $formulario->telefono}}
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
        @if ($formulario->puntoReferencia_id)
        <p class="mt-5"><strong>Punto de referencia en el mapa: <strong> Cantón Latacunga, Parroquia {{ $formulario->puntoReferencia->barrio->parroquia->nombre }}, Barrio {{ $formulario->puntoReferencia->barrio->nombre }}, Sector {{ $formulario->puntoReferencia->referencia }}. Latatitud y Longitud {{ $formulario->puntoReferencia->latitud .','.$formulario->puntoReferencia->longitud }}</p>
            <div id="map" class="mt-1">

            </div>
            
        @else
        <p><strong>Referencia: </strong> {{ $formulario->localidad }}</p>
            <div class="alert alert-danger" role="alert">
                no existe un punto de refrencia en goole map
            </div>
        @endif
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
 <script>
        var map;
            var marker;
        @if( $formulario->puntoReferencia_id )
            function initMap() {
                @if($formulario->estaciones->count()>0)
                    @foreach($formulario->estaciones as $estacion)
                        var directionsRenderer{{$estacion->id}} = new google.maps.DirectionsRenderer;
                        var directionsService{{$estacion->id}} = new google.maps.DirectionsService;
                    @endforeach
                @endif
                var myLatLng={lat: -0.7945178, lng: -78.62189341068114}
                map = new google.maps.Map(document.getElementById('map'), {
                  center: myLatLng,                 
                  zoom: 15,
                });
                
                var imageEstacion="{{ asset('img/ESTACION1.png') }}";
                var imagePuntos="{{ asset('img/puntos.png') }}";
            
                @if($formulario->estaciones->count()>0)
                    @foreach($formulario->estaciones as $estacion)
                    @if ($estacion->latitud&&$estacion->longitud)
                         
                            var latitu={{$estacion->latitud}};
                            var longi={{$estacion->longitud}};
                            var marker_{{$estacion->id}} = new google.maps.Marker({
                                map: map,
                                position:{lat:latitu , lng:longi } ,
                                title:"{{$estacion->nombre}}",
                                icon:imageEstacion,
                            });
                            
                            var nombre="{{$estacion->nombre}}";
                            var geocoder = new google.maps.Geocoder;
                            var infowindow = new google.maps.InfoWindow;
                            infowindow.setContent(nombre);
                            var latitud={{$formulario->puntoReferencia->latitud}};
                            var longitud={{$formulario->puntoReferencia->longitud}};
                            infowindow.open(map, marker_{{$estacion->id}}); 
    
                            directionsRenderer{{$estacion->id}}.setMap(map);
                            // des aki para ver 
                            directionsService{{$estacion->id}}.route({
                            origin: {lat: latitu, lng: longi},  // Haight.
                            destination: {lat: latitud, lng:longitud},  // Ocean Beach.
                            // Note that Javascript allows us to access the constant
                            // using square brackets and a string value as its
                            // "property."
                            
                            travelMode: 'DRIVING',
                            }, function(response, status) {
                            if (status == 'OK') {
                                directionsRenderer{{$estacion->id}}.setDirections(response);
                            } else {
                                window.alert('Directions request failed due to ' + status);
                            }
                            });
                          
                        @endif
                    @endforeach
                @endif         
            }
        @endif
    
    
            
    </script>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&callback=initMap">
      </script>
      <style type="text/css">
          #map {
              height: 350px;
              width: 100%;
          }
      </style>
@endprepend

@endsection