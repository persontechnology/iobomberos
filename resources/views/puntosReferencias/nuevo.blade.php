@extends('layouts.app',['title'=>'Puntos de Referencia'])

@section('breadcrumbs', Breadcrumbs::render('nuevoPuntoReferencia'))

@section('content')

<form method="post" action="{{route('puntosReferenciaGuardar')}}" id="puntosForm" >
	@csrf
	<div class="card">
		<div class="card-header">
			Complete información
		</div>
		<div class="card-body">
			
			<div id="map" style="width: 100%;height: 500px;"></div>
			
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="parroquias">Parroquias</label>
					<select id="parroquias" class="form-control" onchange="obtenerBarrio(this);">
						<option value=""> Selecione una parroquia</option>
						@foreach ($parroquias as $parroquia)
							<option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="barrio">Barrios</label>
					<select id="barrio" name="barrio" class="form-control" required>
					</select>
				</div>	
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="name">{{ __('Latitud') }}</label>	           
					<input id="latitud" type="text" class="form-control @error('latitud') is-invalid @enderror" name="latitud" value="{{ old('latitud') }}" required autocomplete="latitud" autofocus placeholder="Latitud" readonly>

					@error('latitud')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="form-group col-md-6">
					<label for="name" >{{ __('Longitud') }}</label>	           
					<input id="longitud" type="text" class="form-control @error('longitud') is-invalid @enderror" name="longitud" value="{{ old('longitud') }}" required autocomplete="longitud" readonly autofocus placeholder="Longitud">
					@error('longitud')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror	
				</div>
			</div>
			

			<div class="form-group">
				<label for="referencia" >{{ __('Referencia') }}</label>	           
				<textarea id="referencia" class="form-control @error('referencia') is-invalid @enderror" name="referencia" placeholder="Referencia" required>{{ old('referencia') }}</textarea>
				@error('referencia')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror	
			</div>
			
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-dark">Guardar</button>
		</div>
	</div>
</form>



@push('linksCabeza')
 <script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>
@endpush

@prepend('linksPie')

<script type="text/javascript">
   	$('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
    $('#menuPuntosReferencia').addClass('active');
	$( "#puntosForm" ).validate();

	function obtenerBarrio(arg)
	{
		$('#barrio').html('');
		var id=arg.value;
		if(id){
			
			$.blockUI({message:'<h1>Espere por favor.!</h1>'});
			$.post("{{ route('obtenerBarrios') }}", { parroquia: id })
			.done(function( data ) {
				var fila;
				$.each(data, function(i, item) {
					fila+='<option value="'+item.id+'">'+item.nombre+'</option>'
				});
				$('#barrio').append(fila);
			}).always(function(){
				$.unblockUI();
			}).fail(function(){
				notificar("error","Ocurrio un error");
			});
		}
	}
	  
</script>

<script>
	/*Inicializa el mapa en haciendo referencia al departamento*/
	var map;
	var marker;
	function initMap() {
		var myLatLng={lat: -0.8335256701588568, lng: -78.62189341068114}
		map = new google.maps.Map(document.getElementById('map'), {
		  center: myLatLng,
		  zoom: 10,
		  mapTypeId: 'hybrid'
		});
		var imageEstacion="{{ asset('img/ESTACION2.png') }}";
		var imagePuntos="{{ asset('img/puntos.png') }}";
		var imageCrear="{{ asset('img/crear.png') }}";
		@if($estaciones->count()>0)
			@foreach($estaciones as $estacion)
				var latitu={{$estacion->latitud}};
				var longi={{$estacion->longitud}};
				var marker_{{$estacion->id}} = new google.maps.Marker({
			    map: map,
			     position:{lat:latitu , lng:longi } ,
			    title:"Nombre de la estación {{$estacion->nombre}}",
			    icon:imageEstacion,


			 	 });
			@endforeach
		@endif
		@if($puntos->count()>0)
			@foreach($puntos as $punto)
				var latitu={{$punto->latitud}};
				var longi={{$punto->longitud}};
				var markerpuntos_{{$punto->id}} = new google.maps.Marker({
					map: map,
					position:{lat:latitu , lng:longi } ,
					title:" {{$punto->referencia}}",
					icon:imagePuntos,
				});
			@endforeach
		@endif	
		var marker = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    position: myLatLng,
		    title:"Puntos de referencia",
			icon:imageCrear,
			
		  });
		  marker.setMap(map);
		  marker.addListener('dragend', function() {
		    var destinationLat = marker.getPosition().lat();
		    var destinationLng = marker.getPosition().lng(); 
		    puntosEspecificos(destinationLat,destinationLng)      
		  });		
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
		

	}
	
	/*funcion para buscar latitud y longitud en casa de que exista
	-1.2768936132798347
	-78.63767815143547
	*/
function geocodeLatLng(geocoder, map, infowindow,marker) {
    var lati = $('#latitud').val();
    var longi =$('#longitud').val();
    var latlng = {lat: parseFloat(lati), lng: parseFloat(longi)};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          map.setZoom(11);
          marker.setMap(null);
          var marker1 = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    draggable:true,
		    position: latlng,			    
		  });
		  marker1.setMap(map);
		  marker1.addListener('dragend', function() {
		    var destinationLat = marker1.getPosition().lat();
		    var destinationLng = marker1.getPosition().lng(); 
		    puntosEspecificos(destinationLat,destinationLng);
		    infowindow.setContent(null)
			infowindow.open(null)
		  });
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker1);        
        } else {
          notificar("warning","Resultados no encontrados");
        }
      } else {
        notificar("info","La latitud y longitud son icorrectas");
      }
    });
}

function puntosEspecificos($lat,$long) {
	$('#latitud').val($lat);
	$('#longitud').val($long);
}
</script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&callback=initMap">
</script>

<style type="text/css">
	  #map {
        height: 60%;
        

      }
</style>
@endprepend

@endsection
