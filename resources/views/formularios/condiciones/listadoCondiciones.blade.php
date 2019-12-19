@if ($formulario->tipoIncendioForestal && $formulario->etapaIncendioForestal)
<h6 class="mt-1"><strong> 4.1. CONDICIONES CLIMÁTICAS</strong></h6>
<textarea class="form-control @error('condicionClimatica') is-invalid @enderror" name="condicionClimatica" id="condicionClimatica" cols="20" required rows="5">{{ old('condicionClimatica',$formulario->condicionClimatica) }}</textarea>
@error('condicionClimatica')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
<h6 class="mt-1"><strong> 4.2. LOCALIZACION</strong></h6>

@if ($formulario->puntoReferencia_id)
<p class="mt-1"><strong> El incendio forestal se desarrollo en el cantón Latacunga, Parroquia {{ $formulario->puntoReferencia->barrio->parroquia->nombre }}, Barrio {{ $formulario->puntoReferencia->barrio->nombre }}, Sector {{ $formulario->puntoReferencia->referencia }}. Latatitud y Longitud {{ $formulario->puntoReferencia->latitud .','.$formulario->puntoReferencia->longitud }}</strong></p>  
<div id="map">
    </div>
@else
    <div class="alert alert-danger" role="alert">
        no existe punto de referencia
    </div>
@endif
<table class="table-border text-center">
        <tr>
            <th colspan="6">
                    <h6 class="mt-1"><strong> 4.3. TIPO INCENDIO</strong></h6>
            </th>
        </tr>
        <tr>
            <th>
                Agrícola
                <input class="mt-1" type="checkbox"  name="agricola" id="agricola" {{ old('agricola',$formulario->tipoIncendioForestal->agricola)=='1'?'checked':'' }}>
            </th>
            <th>
                Suelo
                <input class="mt-1" type="checkbox"  name="suelo" id="suelo" {{ old('suelo',$formulario->tipoIncendioForestal->suelo)=='1'?'checked':''}}>
    
            <th>
                Copas
                <input class="mt-1" type="checkbox"  name="copas" id="copas" {{ old('copas',$formulario->tipoIncendioForestal->copas)=='1'?'checked':''}}>
    
            <th>
                Sub Suelo
                <input class="mt-1" type="checkbox"  name="subSuelo" id="subSuelo" {{ old('subSuelo',$formulario->tipoIncendioForestal->subSuelo)=='1'?'checked':''}}>
    
        </tr>
    </table>  
    <table class="table-border text-center">
        <tr>
            <th colspan="6">
                    <h6 class="mt-1"><strong> 4.4. ETAPAS DEL INCENDIO.</strong></h6>
            </th>
        </tr>
        <tr>
            
            <th>
                Iniciación
                <input class="mt-1" type="checkbox"  value="1" name="iniciacion" id="iniciacion" {{ old('iniciacion',$formulario->etapaIncendioForestal->iniciacion)=='1'?'checked':'' }}>
            </th>
            <th>
                Propagación
                <input class="mt-1" type="checkbox"  value="1" name="propagacion" id="propagacion" {{ old('propagacion',$formulario->etapaIncendioForestal->propagacion)=='1'?'checked':'' }}>
            </th>
            <th>
                Estabilizado
                <input class="mt-1" type="checkbox"  value="1" name="estabilizado" id="estabilizado" {{ old('estabilizado',$formulario->etapaIncendioForestal->estabilizado)=='1'?'checked':'' }}>
            </th>
            <th>
                Activo
                <input class="mt-1" type="checkbox"  value="1" name="activo" id="activo" {{ old('activo',$formulario->etapaIncendioForestal->activo)=='1'?'checked':'' }}>
            </th>
            <th>
                Controlado
                <input class="mt-1" type="checkbox"  value="1" name="controlado" id="controlado" {{ old('controlado',$formulario->etapaIncendioForestal->controlado)=='1'?'checked':'' }}>
            </th> 
            <th>
                Extinguido
                <input class="mt-1" type="checkbox"  value="1" name="extinguido" id="extinguido" {{ old('extinguido',$formulario->etapaIncendioForestal->extinguido)=='1'?'checked':'' }}>
            </th>                         
    
        </tr>
    
     
        </table>
 
    <div class="mt-2 text-center">
    
        <a onclick="eliminarEdificacionForestal(this)" data-id="{{ $formulario->id }}" class="btn btn-danger text-white">Eliminar etapas incendio forestal<i class="icon-bin  ml-2"></i> </a>      
    </div>   
@else
<a onclick="crearEdificacionForestal(this)" data-id="{{ $formulario->id }}" class="btn btn-success text-white">Crear tipo de incendio forestal<i class="icon-fire2  ml-2"></i> </a>   
@endif

<script>

function eliminarEdificacionForestal(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea eliminar etapas forestales del formulario !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, eliminar!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('eliminar-forestal-formulario') }}", { formulario: $(arg).data('id') })
            .done(function( data ) {
                if(data.success){
                    
                    notificar("info",data.success);
                    cargarTipoIncendioForestal();
                }
                if(data.default){
                    notificar("default",data.default);   
                }
                console.log(data)
            }).always(function(){
                $.unblockUI();
            }).fail(function(){
                notificar("error","Ocurrio un error");
            });

        });
    }
function crearEdificacionForestal(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea crear edificación forestal al formulario !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, crear!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('guardar-forestal-formulario') }}", { formulario: $(arg).data('id') })
            .done(function( data ) {
                if(data.success){
                    
                    notificar("info",data.success);
                    cargarTipoIncendioForestal();
                }
                if(data.default){
                    notificar("default",data.default);   
                }
                console.log(data)
            }).always(function(){
                $.unblockUI();
            }).fail(function(){
                notificar("error","Ocurrio un error");
            });

        });
    }
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
            mapTypeId: 'satellite',
            
               
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