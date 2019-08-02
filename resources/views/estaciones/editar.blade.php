@extends('layouts.app',['title'=>'Editar estacion'])

@section('breadcrumbs', Breadcrumbs::render('editarEstacion',$estacion))

@section('content')

<div class="card">
    <div class="card-header">
    	<h4 class="card-title">
         	Crear nueva estación
    	</h4>
    </div>
    <div class="card-body"> 
	  	<form action="{{route('actualizarEstacion')}}" method="post"  enctype="multipart/form-data">
	        @csrf
	        <fieldset class="mb-3">
			<div class="row">
				<div class="col-sm-6">
					<input type="hidden" name="estacion" id="estacion" value="{{$estacion->id}}">
		            <div class="form-group row">
		                <label class="col-form-label col-lg-3">Nombre <span class="text-danger">*</span></label>
		                <div class="col-lg-9">
		                    <input type="text"  id="nombre" name="nombre" value="{{ old('nombre',$estacion->nombre) }}" required class="form-control @error('nombre') is-invalid @enderror" >
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
		                    <input type="text"  id="direccion" name="direccion" value="{{ old('direccion',$estacion->direccion) }}" required class="form-control @error('direccion') is-invalid @enderror" >
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
		        	<p class="text-center">Ubicación de la estación</p>
		        	<div class="input-group">
						 <div class="input-group-prepend">
						    <span class="input-group-text">lat</span>
						 </div>
						 <input type="text"  id="latitud" name="latitud" value="{{ old('latitud',$estacion->latitud) }}"  class="form-control @error('latitud') is-invalid @enderror" >
						 <div class="input-group-prepend">
						    <span class="input-group-text">Long</span>
						 </div>
						 <input   value="{{ old('longitud',$estacion->longitud) }}" id="longitud" name="longitud"  type="text" class="@error('longitud') is-invalid @enderror form-control"  >
						 <a class="btn btn-dark text-white" id="buscarUbicacion"><i class="icon-search4"></i></a>
					</div>
	        <!-- datso para la ubicacion en google maop -->	  
					<div id="map"></div>        	
		        </div>
		    </div>	        
	        </fieldset>
	        <div class="text-right">
	            <button type="submit" class="btn btn-primary">Actualizar <i class="icon-paperplane ml-2"></i>
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
  
  
@endpush

@prepend('linksPie')
  <script type="text/javascript">
       $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuEstacion').addClass('active');
  </script>
 <script>
 @if($estacion->foto)
  var foto="<img class='kv-preview-data file-preview-image' src='{{ Storage::url('public/estaciones/'.$estacion->foto) }}'>";
@else
var foto="<img class='kv-preview-data file-preview-image' src='{{ asset('global_assets/images/estacion.jpg') }}'>";
@endif

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
    showUpload: false,
    initialPreview: [foto],
    allowedFileExtensions: ["jpg", "png", "gif"],
})

 </script>
 <script>
	/*Inicializa el mapa en haciendo referencia al departamento*/
	
	var map;
	var marker;
	function initMap() {
		@if($estacion->latitud!=""&&$estacion->longitud!="")
		var myLatLng={lat: {{$estacion->latitud}}, lng: {{$estacion->longitud}}}
		@else
		var myLatLng={lat: -0.9392135, lng: -78.6087184}
		@endif
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

</script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&callback=initMap">
</script>
<script>
    $('#menuNinios').addClass('active');
</script>
@endprepend
<style type="text/css">
  #map {
    height: 400px;
    width: auto;
  }
</style>
@endsection