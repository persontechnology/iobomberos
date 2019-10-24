@extends('layouts.app',['title'=>'Puntos de Referencia'])
@section('breadcrumbs', Breadcrumbs::render('mapaPuntoReferencia'))

@section('content')
<select class="form-control"  name="" id="buscarBarrios">
	<option value="todos">Todos</option>
	@if ($parroquias)
		@foreach ($parroquias as $parroquia)
			<option value="{{$parroquia->id}}">{{$parroquia->nombre}}</option>
		@endforeach
	@endif
</select>
<br>
<div id="map"></div>


@push('linksCabeza')

@endpush

@prepend('linksPie')

<script type="text/javascript">
   $('#menuGestionPuntos').addClass('nav-item-expanded nav-item-open');
   $('#menuPuntosReferencia').addClass('active');
  
</script>
<script>
	/*Inicializa el mapa en haciendo referencia al departamento*/
	var map;
	var marker;
	function initMap() {
		var myLatLng={lat: -0.8335256701588568, lng: -78.62189341068114}
		map = new google.maps.Map(document.getElementById('map'), {
		  center: myLatLng,
		  zoom: 12,
		  
		});
	
		var imageEstacion="{{ asset('img/ESTACION1.png') }}";
		var imagePuntos="{{ asset('img/puntos.png') }}";
	
		@if($estaciones->count()>0)
			@foreach($estaciones as $estacion)
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
		document.getElementById('buscarBarrios').addEventListener('change', function() {
			var id=document.getElementById('buscarBarrios').value;
			if(id=="todos"){
				@if($puntos->count()>0)
					@foreach($puntos as $punto)
				var latitu={{$punto->latitud}};
				var longi={{$punto->longitud}};
				var markerpuntos_{{$punto->id}} = new google.maps.Marker({
			    map: map,
			     position:{lat:latitu , lng:longi } ,
			    title:" {{$punto->barrio->nombre .' '. $punto->referenica}}",
			    icon:imagePuntos,
			 	 });
				var nombre="{{$punto->barrio->nombre .' '.$punto->referencia}}";
				var geocoder = new google.maps.Geocoder;
			     var infowindow1 = new google.maps.InfoWindow;
			     infowindow1.setContent(nombre);
			      infowindow1.open(map, markerpuntos_{{$punto->id}}); 

				@endforeach
				@endif
			}else{
				if(id){			
				$.blockUI({message:'<h1>Espere por favor.!</h1>'});
				$.post("{{ route('obtenerBarrios') }}", { parroquia: id })
				.done(function( data ) {
					var fila;
					$.each(data, function(i, item) {
						console.log(item.nombre)
					});
					
				}).always(function(){
					$.unblockUI();
				}).fail(function(){
					notificar("error","Ocurrio un error");
				});
			}
			}

		})
			

	}


</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&callback=initMap">
</script>

<style type="text/css">
	  #map {
        height: 100%;
        

      }
</style>

@endprepend

@endsection
