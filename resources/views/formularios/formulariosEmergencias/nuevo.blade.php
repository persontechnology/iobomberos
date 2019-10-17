@extends('layouts.app',['title'=>'formularios'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
       <div class="card-body">
        <form method="POST" action="#" id="formNuevoUsuario" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="emergencia" class="col-md-3 col-form-label text-md-right">{{ __('Emergencia') }}<i class="text-danger">*</i></label>

                        <div class="col-md-9">
                            @if($emergencias)
                                <select class="form-control @error('emergencia') is-invalid @enderror" name="emergencia" id="emergencia" >
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
                            <input type="radio" checked class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="L-V" id="L-V" name="frecuencia"  required >
                            <label class="custom-control-label" for="L-V">Lunes-Viernes</label>
                        </div>                                
                        <div class="custom-control custom-radio">
                                <input type="radio"  class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Fin de Semana" id="Fin de Semana" name="frecuencia"  required >
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
                                <input type="radio" class="custom-control-input{{ $errors->has('formaAviso') ? ' is-invalid' : '' }}" value="Telefonico" id="Telefonico" name="formaAviso" required >
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
                <label class=" col-form-label text-md-right" for="formaAviso">Punto de Referencia<i class="text-danger">*</i></label>
                    <div class="col-md-9"> 
                    <select id="puntoRe" class="form-control selectpicker  @error('puntoReferencia') is-invalid @enderror" data-live-search="true" name="puntoReferencia" required>
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
            
        </form>
        
    </div>
</div>

@push('linksCabeza')
<link rel="stylesheet" href="{{ asset('admin/plus/select/css/bootstrap-select.min.css') }}">
<script src="{{ asset('admin/plus/select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/plus/select/js/lg/defaults-es_ES.min.js') }}"></script>

@endpush

@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuFormularios').addClass('active');
     $('selectpicker').selectpicker();
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