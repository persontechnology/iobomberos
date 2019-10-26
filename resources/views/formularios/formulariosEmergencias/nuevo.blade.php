@extends('layouts.app',['title'=>'Nuevo formulario'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
    <form method="POST" action="{{ route('guardarFormulario') }}" id="formNuevoUsuario" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="emergencia" class="col-md-3 col-form-label text-md-right">{{ __('Emergencia') }}<i class="text-danger">*</i></label>

                        <div class="col-md-9">
                            @if($emergencias)
                                <select class="form-control @error('emergencia') is-invalid @enderror" required name="emergencia" id="emergencia" >
                                    @foreach($emergencias as $esta)
                                    <option value="{{ $esta->id }}" {{ (old("emergencia") == $esta->id ? "selected":"") }} >{{$esta->nombre}}</option>
                                    @endforeach
                                </select>

                                @error('emergencia_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group row">
                            <label for="institucion" class="col-md-4 col-form-label text-md-right">{{ __(' Nombre Institución') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="institucion" type="text" class="form-control @error('institucion') is-invalid @enderror" name="institucion" value="{{ old('institucion') }}" required autocomplete="institucion" autofocus placeholder="institucion">
        
                                @error('institucion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>

            </div>

    
            <div class="row">
                <div class="col-sm-6">
                    <div class=" form-row">
                        <label class="col-md-3 col-form-label text-md-right" for="formaAviso">Frecuencia<i class="text-danger">*</i></label>
                        <div class="col-md-9">
                        <div class="custom-control custom-radio">
                            <input type="radio" checked class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Lunes-Viernes" id="L-V" name="frecuencia"  required >
                            <label class="custom-control-label" for="L-V">Lunes-Viernes</label>
                        </div>                                
                        <div class="custom-control custom-radio">
                            <input type="radio"  class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Fin de semana" id="Fin de Semana" name="frecuencia"  required >
                            <label class="custom-control-label" for="Fin de Semana">Fin de Semana</label>
                        </div> 
                        <div class="custom-control custom-radio ">
                            <input type="radio" class="custom-control-input{{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Feriado" id="Feriado" name="frecuencia" required >
                            <label class="custom-control-label" for="Feriado">Feriado</label>
                                
                                @if ($errors->has('frecuencia'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('formaAviso') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">                  
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right" for="formaAviso">Forma de Aviso<i class="text-danger">*</i></label>
                            <div class="col-md-6"> 
                            <div class="custom-control custom-radio">
                                <input type="radio" checked class="custom-control-input {{ $errors->has('formaAviso') ? ' is-invalid' : '' }}" value="Personal" id="Personal" name="formaAviso"  required >
                                <label class="custom-control-label" for="Personal">Personal</label>
                            </div>                                
        
                            <div class="custom-control custom-radio ">
                                <input type="radio" class="custom-control-input{{ $errors->has('formaAviso') ? ' is-invalid' : '' }}" value="Teléfonico" id="Telefonico" name="formaAviso" required >
                                <label class="custom-control-label" for="Telefonico">Telefónico</label>
                                    
                                    @if ($errors->has('formaAviso'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('formaAviso') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            {{-- ingreso del mapa con su respectiva seleción de barrio --}}            
            
            <div class="form-row">
                <label class=" col-form-label text-md-right" for="formaAviso">Seleccione el punto de Referencia<i class="text-danger">*</i></label>
                <div class="col-md-12"> 
                    <select id="puntoRe" class="form-control selectpicker  @error('puntoReferencia') is-invalid @enderror" data-live-search="true" name="puntoReferencia"  required>
                        <option value=" ">Selecione un punto de referencia</option>
                        @foreach ($parroquias as $parroquia)
                        <optgroup label="Parroquia: {{$parroquia->nombre}}">
                            @foreach ($parroquia->barrios as $barrio)
                                @foreach ($barrio->puntosRefencias as $puntoReferencia)
                                <option data-subtext="P.R : {{ $puntoReferencia->referencia }} " value="{{ $puntoReferencia->id }}" {{ (old("puntoReferencia") == $puntoReferencia->id ? "selected":"") }}>Barrio: {{ $barrio->nombre }}</option>                                    
                                @endforeach
                            @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>                        	
            </div> 
            
            <div id="map">
            </div>

            <div class="border mb-1 mt-1">
                <label for="">Selecione Vehículos</label>


                <div class="row">
                    <div class="col-md-6">
                            @if (count($estaciones)>0)

                            <ul class="nav nav-pills mb-3 mt-2 ml-2" id="pills-tab" role="tablist">
                                
                                @php($est_i=0)
                                @foreach ($estaciones as $estacion_f)
                                @php($est_i++)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $est_i==1?'active':'' }}" id="pills-{{ $estacion_f->id }}-tab" data-toggle="pill" href="#pills-{{ $estacion_f->id }}" role="tab">
                                            {{ $estacion_f->nombre }}
                                        </a>
                                    </li>
                                @endforeach
        
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @php($est_c=0)
                                @foreach ($estaciones as $estacion_c)
                                @php($est_c++)
                                <div class="tab-pane fade {{ $est_c==1?'show active':'' }}" id="pills-{{ $estacion_c->id }}" role="tabpanel" aria-labelledby="pills-{{ $estacion_c->id }}-tab">
                                        @if (count($estacion_c->vehiculosDisponibles)>0)
                                        <label for="" class="ml-1">Vehículos</label>
                                        <div class="row ml-1">
                                            @foreach ($estacion_c->vehiculosDisponibles as $vehiculo)
                                            <div class="col-xl-3 col-xs-6">
                                                <div class="card">
                                                    @if (Storage::exists($vehiculo->foto))
                                                        <img src="{{ Storage::url($vehiculo->foto) }}" class="card-img-top" alt="...">
                                                    @else
                                                        <img src="{{ asset('img/carroBomberos.png') }}" alt="" class="card-img-top">
                                                    @endif

                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input type="checkbox" onchange="agregarVehiculo(this);" class="form-check-input" data-id="{{ $vehiculo->id }}" data-nombre="{{ $vehiculo->tipoVehiculo->codigo.''.$vehiculo->codigo }}" value="{{ $vehiculo->id }}" id="check_v_{{ $vehiculo->id }}">
                                                            <label class="form-check-label" for="check_v_{{ $vehiculo->id }}">
                                                                {{ $vehiculo->tipoVehiculo->codigo.''.$vehiculo->codigo }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            <strong>No existe veículos disponibles en esta estación</strong>
                                        </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
        
                        @else
                            <div class="alert alert-danger" role="alert">
                                <strong>No existe estaciones para generar un formulario de emergencia</strong>
                            </div>    
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="">Agregar responsables a vehículos</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Vehículo</th>
                                        <th scope="col">Operador</th>
                                        <th scope="col">Acompañantes</th>
                                        <th scope="col">Paramédico</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="personales">

                                </tbody>
                            </table>
                    </div>
                    </div>
                </div>


                
            </div>

            <div class="table-reponsive">
                <button type="button" class="btn btn-danger">
                    <i class=""></i>
                </button>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Generar Ficha</button>
        </div>
    </form>
</div>

@push('linksCabeza')
<link rel="stylesheet" href="{{ asset('admin/plus/select/css/bootstrap-select.min.css') }}">
<script src="{{ asset('admin/plus/select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/plus/select/js/lg/defaults-es_ES.min.js') }}"></script>

@endpush

@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuNuevoFormularios').addClass('active');
     $('selectpicker').selectpicker();


     function agregarVehiculo(arg){
         
        var vehiculo=$(arg).data('nombre');
        var id=$(arg).data('id');
        var estado=arg.checked;

        
        if($('#fila_'+id).length){
            $('#fila_'+id).remove();
        }else{
            var fila='<tr id="fila_'+id+'">'+
                    '<th scope="row">'+vehiculo+'</th>'+
                    '<td>Mark</td>'+
                    '<td>Otto</td>'+
                    '<td>@mdo</td>'+
                    '<td></td>'+
                    '</tr>';
            $('#personales').append(fila)
        }
        
        

         
     }
</script>

<script>
        /*Inicializa el mapa en haciendo referencia al departamento*/
        var map;
        var marker;
        function initMap() {
            @if($estaciones->count()>0)
                @foreach($estaciones as $estacion)
                    var directionsRenderer{{$estacion->id}} = new google.maps.DirectionsRenderer;
                    var directionsService{{$estacion->id}} = new google.maps.DirectionsService;
                @endforeach
            @endif
            var myLatLng={lat: -0.7945178, lng: -78.62189341068114}
            map = new google.maps.Map(document.getElementById('map'), {
              center: myLatLng,
              zoom: 11,
              
            });
            
            var imageEstacion="{{ asset('img/ESTACION1.png') }}";
            var imagePuntos="{{ asset('img/puntos.png') }}";
        
            @if($estaciones->count()>0)
                @foreach($estaciones as $estacion)
                @if ($estacion->latitud&&$estacion->longitud)
                        directionsRenderer{{$estacion->id}}.setMap(map);
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
                        infowindow.open(map, marker_{{$estacion->id}}); 
                    @endif
                @endforeach
            @endif	  
            
            document.getElementById('puntoRe').addEventListener('change', function() {
                var id=document.getElementById('puntoRe').value;
                var selectedMode = "DRIVING";
                // bucar punto de referencia en enfacis al id del select
                $.blockUI({message:'<h1>Espere por favor.!</h1>'}); 
                $.post( "{{route('buscarPuntosReferencia')}}", { id: id })
                .done(function( data ) {
                    $.blockUI({message:'<h1>Espere por favor.!</h1>'});                  
                    if(data){
                        @if($estaciones->count()>0)
                            @foreach($estaciones as $estacion)
                            @if ($estacion->latitud&&$estacion->longitud)
                                
                                var latitu={{$estacion->latitud}};
                                var longi={{$estacion->longitud}};
                                    
                                    directionsService{{$estacion->id}}.route({
                                        
                                    origin: {lat: latitu, lng: longi},  // Haight.
                                    destination: {lat: parseFloat(data.latitud), lng: parseFloat(data.longitud)},  // Ocean Beach.
                                    
                                    travelMode: google.maps.TravelMode[selectedMode]
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
                    }else{
                        notificar("info","no se encontraron datos");
                    }
                
                }).always(function(){
                    $.unblockUI();
                }).fail(function(){
                    notificar("error","Ocurrio un error");
                });               
                
            });
    
        }
        @if($estaciones->count()>0)
        @foreach($estaciones as $estacion)
            @if ($estacion->latitud&&$estacion->longitud)
                var latitu={{$estacion->latitud}};
                var longi={{$estacion->longitud}};
                function calculateAndDisplayRoute{{$estacion->id}}(directionsService, directionsRenderer,latitud,longitud) {
                    var selectedMode = "DRIVING";
                    directionsService.route({
                        origin: {lat: latitu, lng: longi},  // Haight.
                        destination: {lat: parseFloat(latitud), lng: parseFloat(longitud)},  // Ocean Beach.
                        // Note that Javascript allows us to access the constant
                        // using square brackets and a string value as its
                        // "property."
                        travelMode: 'DRIVING',
                    }, function(response, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                    });
                }
            @endif
      @endforeach
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