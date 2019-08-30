@extends('layouts.app',['title'=>'Nuevo estacion'])

@section('breadcrumbs', Breadcrumbs::render('nuevaEstacion'))

@section('content')

<div class="card">
    <div class="card-header">
        Complete información
    </div>
    <div class="card-body"> 
	  	<form action="{{route('guardarEstacion')}}" method="post" id="formNuevo"  enctype="multipart/form-data">
	        @csrf
	        <fieldset class="mb-3">
			<div class="row">
				<div class="col-sm-6"> 			

		            <div class="form-group row">
		                <label class="col-form-label col-lg-3">Nombre <span class="text-danger">*</span></label>
		                <div class="col-lg-9">
		                    <input type="text" placeholder="Nombre" id="nombre" name="nombre" value="{{ old('nombre') }}" required class="form-control @error('nombre') is-invalid @enderror" >
		                    @error('nombre')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                    @enderror
		                </div>
		            </div>
		            <div class="form-group row">
		                <label class="col-form-label col-lg-3">Dirección <span class="text-danger">*</span></label>
		                <div class="col-lg-9">
		                    <input type="text"  id="direccion" placeholder="Dirección" name="direccion" value="{{ old('direccion') }}" required class="form-control @error('direccion') is-invalid @enderror" >
		                    @error('direccion')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                    @enderror
		                </div>
		            </div>

		            <div class="form-group row">
		                <label class="col-form-label col-lg-3">Imagen <span class="text-danger">*</span></label>
		                <div class="col-lg-9">
		                    <input type="file"  id="foto" name="foto" value="{{ old('foto') }}"  class="form-control @error('foto') is-invalid @enderror" >
		                    @error('foto')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                    @enderror
		                </div>
		            </div>
		        </div>
		        <div class="col-sm-6">
		        	<label for="Ubicación de la estación"></label>
		        	<div class="input-group">
						 <div class="input-group-prepend">
						    <span class="input-group-text">lat</span>
						 </div>
						 <input type="text"  id="latitud" name="latitud" value="{{ old('latitud') }}"  class="form-control @error('latitud') is-invalid @enderror" >
						 <div class="input-group-prepend">
						    <span class="input-group-text">Long</span>
						 </div>
						 <input   value="{{ old('longitud') }}" id="longitud" name="longitud"  type="text" class="@error('longitud') is-invalid @enderror form-control"  >
						 <a class="btn btn-dark text-white" id="buscarUbicacion"><i class="icon-search4"></i></a>
					</div>
	        <!-- datso para la ubicacion en google maop -->	  
					<div id="map"></div>        	
		        </div>
		    </div>	        
	        </fieldset>
	        <div class="text-right">
	            <button type="submit" class="btn btn-dark">Guardar
	            </button>
	        </div>
    	</form>
    </div>
   
</div>


@push('linksCabeza')
<link href="{{ asset('admin/plus/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/plugins/piexif.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
<script src="{{asset('admin/plus/bootstrap-fileinput/js/plugins/purify.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/locales/es.js') }}"></script>
{{-- fin file input --}}

{{-- validate --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>
  
  
@endpush

@prepend('linksPie')

 <script>
	$('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
	$('#menuEstacion').addClass('active'); 
	$("#foto").fileinput({
	
	
		maxImageWidth: 1200,
		maxImageHeight: 650,
		resizePreference: 'height',
		autoReplace: true,
		maxFileCount: 1,
		resizeImage: true,
		resizeIfSizeMoreThan: 1000,
		theme:'fas',
		language:'es',
		showUpload: false
	})


	$( "#formNuevo" ).validate({
		rules: {
			nombre: {
				required: true,
				maxlength: 191
			},
			descripcion: {
				required: true,
				direccion: 191
			},
		},
	});

</script>
<script>
	/*Inicializa el mapa en haciendo referencia al departamento*/
	var map;
	var marker;
	function initMap() {
		var myLatLng={lat: -0.933763979292379, lng: -78.61502695560301}
		map = new google.maps.Map(document.getElementById('map'), {
		  center: myLatLng,
		  zoom: 10,
		  mapTypeId: 'hybrid'
		});	
		var marker = new google.maps.Marker({
		    map: map,
		    draggable: true,
		    animation: google.maps.Animation.DROP,
		    draggable:true,
		    position: myLatLng,
		    title:"Oficina CACTU sede Cotopaxi",
		  });
		  marker.setMap(map);
		  marker.addListener('dragend', function() {
		    var destinationLat = marker.getPosition().lat();
		    var destinationLng = marker.getPosition().lng(); 
		    puntosEspecificos(destinationLat,destinationLng)      
		  });		
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
		 document.getElementById('buscarUbicacion').addEventListener('click', function() {
		  geocodeLatLng(geocoder, map, infowindow,marker);
		   
		});

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

@endprepend
<style type="text/css">
  #map {
    height: 400px;
    width: auto;
  }
</style>
@endsection