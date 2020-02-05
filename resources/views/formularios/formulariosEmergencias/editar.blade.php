@extends('layouts.app',['title'=>'Nuevo formulario'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
   <div class="text-center">
       <p><h4><strong>Editar Formulario N° {{$formulario->numero}}</strong></h4></p>
   </div>

    <form method="POST" action="{{ route('ActualizarFormulario') }}" id="formEditarUsuario" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <input type="hidden" name="formulario" id="formulario" value="{{ $formulario->id }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="emergencia">Emergencia<i class="text-danger">*</i></label>
                    @if(count($emergencias)>0)
                        <select class="form-control @error('emergencia') is-invalid @enderror" required name="emergencia" id="emergencia" >
                            @foreach($emergencias as $esta)
                            <option value="{{ $esta->id }}" {{ old('emergencia',$formulario->emergencia_id)==$esta->id?'selected':''  }} >{{$esta->nombre}}</option>
                            @endforeach
                        </select>

                        @error('emergencia')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    @else
                        <div class="alert alert-danger" role="alert">
                            <strong>No existe emergencias, para crear un formulario</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="institucion">Nombre o institución que informa<i class="text-danger">*</i></label>
                    <input id="institucion" type="text" class="form-control @error('institucion') is-invalid @enderror" name="institucion" value="{{ old('institucion',$formulario->institucion) }}" required autocomplete="institucion" autofocus placeholder="Ingrese..">

                    @error('institucion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-md-2">
                    <label for="telefono"># Teléfonico del informante</label>
                    <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono',$formulario->telefono) }}" autocomplete="telefono" autofocus placeholder="Ingrese..">

                    @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>



            <div class="row">
                <div class="col-sm-6">
                    <div class=" form-row">
                        <label class="col-md-3 col-form-label text-md-right" for="formaAviso">Frecuencia<i class="text-danger">*</i></label>
                        <div class="col-md-9">
                        <div class="custom-control custom-radio">
                            <input type="radio" checked class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Lunes-Viernes" id="L-V" {{ old('frecuencia',$formulario->frecuencia)=='Lunes-Viernes'?'checked':'' }} name="frecuencia"  required >
                            <label class="custom-control-label" for="L-V">Lunes-Viernes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio"  class="custom-control-input {{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Fin de semana" id="Fin de Semana" {{ old('frecuencia',$formulario->frecuencia)=='Fin de semana'?'checked':'' }} name="frecuencia"  required >
                            <label class="custom-control-label" for="Fin de Semana">Fin de Semana</label>
                        </div>
                        <div class="custom-control custom-radio ">
                            <input type="radio" class="custom-control-input{{ $errors->has('frecuencia') ? ' is-invalid' : '' }}" value="Feriado" id="Feriado" name="frecuencia" {{ old('frecuencia',$formulario->frecuencia)=='Feriado'?'checked':'' }} required >
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
                                <input type="radio" checked class="custom-control-input {{ $errors->has('formaAviso') ? ' is-invalid' : '' }}" value="Personal" id="Personal" {{ old('formaAviso',$formulario->formaAviso)=='Personal'?'checked':'' }} name="formaAviso"  required >
                                <label class="custom-control-label" for="Personal">Personal</label>
                            </div>

                            <div class="custom-control custom-radio ">
                                <input type="radio" class="custom-control-input{{ $errors->has('formaAviso') ? ' is-invalid' : '' }}" value="Teléfonico" id="Telefonico" {{ old('formaAviso',$formulario->formaAviso)=='Teléfonico'?'checked':'' }} name="formaAviso" required >
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

                <div class="col-md-6">
                    <label class=" col-form-label text-md-right" for="formaAviso">Seleccione el punto de Referencia</label>
                    <select id="puntoRe" class="form-control selectpicker  @error('puntoReferencia') is-invalid @enderror" data-live-search="true" name="puntoReferencia" title="Selecionar punto de referencia" data-header="Selecionar punto de referencia">
                        <option value="" >Sin punto de referencia</option>
                        @foreach ($parroquias as $parroquia)
                        <optgroup label="Parroquia: {{$parroquia->nombre}}">
                            @foreach ($parroquia->barrios as $barrio)
                                @foreach ($barrio->puntosRefencias as $puntoReferencia)
                                <option data-subtext="P.R : {{ $puntoReferencia->referencia }} " value="{{ $puntoReferencia->id }}" {{ (old("puntoReferencia",$formulario->puntoReferencia_id) == $puntoReferencia->id ? "selected":"") }}>Barrio: {{ $barrio->nombre }}</option>
                                @endforeach
                            @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Dirección adicional</label>
                        <input type="text" name="direcionAdicional" value="{{ old('direcionAdicional',$formulario->localidad) }}" class="form-control" id="direcionAdicional" placeholder="Ingrese..">
                    </div>
                </div>
            </div>
            <br>
            <div id="map">
            </div>
            <br>
            @foreach ($formulario->estacionFormularioEmergencias as $estacion)

            <table class="table table-bordered">
                <tbody>
                    <tr class="text-center">
                        <th colspan="4">
                            <strong>{{$estacion->estacion->nombre}}</strong>
                            <br>
                            <div class="text-warning">
                                <strong>Encargado de la estación: </strong>{{$estacion->responsable->name??'XXXXXXXXXX'}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>Unidades</th>
                        <th>Operador</th>
                        <th>Acompañantes</th>
                        <th>Paramédico</th>
                    </tr>
                    @foreach ($estacion->formularioEstacionVehiculo as $vehiculo)
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
            <div class="border mb-1 mt-1">
                <label for="">Selecione Vehículos</label>


                <div class="row">
                    <div class="col-md-12">
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


                                    @if ($estacion_c->asistenciaCreada($formulario->fecha,$estacion_c->id))
                                    @if ($estacion_c->asistenciaCreada($formulario->fecha,$estacion_c->id)->asistenciasAsistenciaVehiculo->count()>0)
                                        <label for="" class="ml-1">Vehículos</label>
                                        <div class="row">
                                            @foreach ($estacion_c->asistenciaCreada($formulario->fecha,$estacion_c->id)->asistenciasAsistenciaVehiculo as $asistenciaVehiculo)
                                            <div class="col-xl-2 col-xs-6">
                                                @if ($asistenciaVehiculo->estado==false)
                                                    <div class="card bg-warning" >
                                                @endif
                                                @if ($asistenciaVehiculo->estado==true &&  $asistenciaVehiculo->estadoEmergencia=='Emergencia')
                                                    <div class="card bg-danger" >
                                                @endif
                                                @if ($asistenciaVehiculo->estado==true &&  $asistenciaVehiculo->estadoEmergencia=='Disponible')
                                                    <div class="card bg-success" >
                                                @endif
                                                @if (Storage::exists($asistenciaVehiculo->vehiculo->foto))
                                                    <img src="{{ Storage::url($asistenciaVehiculo->vehiculo->foto) }}" class="card-img-top" alt="...">
                                                @else
                                                    <img src="{{ asset('img/carroBomberos.png') }}" alt="" class="card-img-top">
                                                @endif
                                                <div class="form-check text-center">
                                                    @if ($asistenciaVehiculo->estado==true &&  $asistenciaVehiculo->estadoEmergencia=='Disponible' )
                                                    <input type="checkbox" onchange="agregarVehiculo(this);" class="form-check-input" data-idasistencia="{{$asistenciaVehiculo->id }}" data-id="{{$asistenciaVehiculo->vehiculo->id }}" data-nombre="{{ $asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$asistenciaVehiculo->vehiculo->codigo }}" value="{{ $asistenciaVehiculo->vehiculo->id }}" id="check_v_{{ $asistenciaVehiculo->vehiculo->id }}">

                                                    @endif
                                                    <label class="form-check-label" for="check_v_{{ $asistenciaVehiculo->vehiculo->id }}">
                                                        {{ $asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$asistenciaVehiculo->vehiculo->codigo }}
                                                    </label>
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
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            <strong>No existe un registro de asistencia de vehículos en la estación {{$estacion_c->nombre}} </strong>
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
                    <div class="col-md-12">
                        <label for="">Agregar responsables a vehículos</label>
                        <div class="table table-responsive">
                            <table class="table-bordered" style=" width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Vehículo</th>
                                        <th scope="col">Operador</th>
                                        <th scope="col">Acompañantes</th>
                                        <th scope="col">Paramédico</th>

                                    </tr>
                                </thead>
                                <tbody id="personales">

                                </tbody>
                            </table>
                    </div>
                    </div>
                </div>
            </div>
            <ul class="list-group">

                @if (count($asistenciaHoy)>0)
                    <li  class="list-group-item">
                        Seleccione Encargado del formulario
                        <select name="encargadoFormulario" id="encargadoFormulario" class="form-control selectpicker  @error('encargadoFormulario') is-invalid @enderror" data-live-search="true" required>

                            @foreach ($asistenciaHoy as $asistencia)
                                <option value="{{$asistencia->id}}" {{ old('encargadoFormulario',$asistencia->id) == $formulario->encardadoFicha_id ? "selected":""}}>{{  $asistencia->usuario->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('encargadoFormulario'))

                            <span class="invalid-feedback" role="alert">
                                <br>
                                <strong>{{ $errors->first('encargadoFormulario') }}</strong>
                            </span>
                        @endif
                    </li>
                    @if (count($formulario->estacionFormularioEmergencias)>0)
                        @foreach ($formulario->estacionFormularioEmergencias as $estacion_c)

                                <li  class="list-group-item">
                                     Responsable de  {{  $estacion_c->estacion->nombre }} : <strong> {{ $estacion_c->user_id!=""?$estacion_c->responsable->name:'no existe' }}  </strong>

                                    </li>



                        @endforeach
                    @else
                        <div class="alert alert-danger" role="alert">
                            <strong>No existe estaciones para generar un formulario de emergencia</strong>
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger" role="alert">
                        <strong>No existe personal en asistencia</strong>
                    </div>
                @endif
            </ul>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Actualizar formulario</button>
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
        var idAsistencia=$(arg).data('idasistencia');
        var fecha="{{ $formulario->fecha }}"
        var estado=arg.checked;

        if($('#fila_'+id).length){
            notificar("warning","Vehículo removido");
            $('#fila_'+id).remove();
        }else{
            notificar("info","Vehículo asignado");
            var operador='<select   id="operador_'+id+'"  name="operador[]"   class="form-control selectpicker"  required>'+
                    '</select>';
            var operativos='<select id="operativos_'+id+'"  multiple="multiple" name="operativos[]" class="form-control " required>'+
                    '</select>';
            var paramedico='<select  id="paramedico_'+id+'"  name="paramedico[]" class="form-control" >'+
            '</select>';

            var fila='<tr id="fila_'+id+'">'+
                        '<th ><input type="hidden" name="vehiculos[]" value="'+idAsistencia+'" />'+vehiculo+'</th>'+
                        '<td>'+operador+'</td>'+
                        '<td>'+operativos+'</td>'+
                        '<td>'+paramedico+'</td>'+

                    '</tr>';
            $('#personales').append(fila);

            cargarOperadoresEditar(id,fecha);
            cargarOperativosEditar(id,idAsistencia,fecha);
            cargarParamedicoEditar(id,fecha);
        }

        function cargarOperadoresEditar(id){

            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{route('buscarPersonalOperadorFormularioEditar')}}", { vehiculo: id,fecha:fecha })
            .done(function( data ) {
                var fila;
                var palabraClave;
                $.each(data, function(i, item) {
                    palabraClave=item.split('--')
					fila+='<option value="'+palabraClave[2]+'"><strong>'+palabraClave[1] + ' : '+ palabraClave[0]+'</strong></option>'
				});
                $('#operador_'+id).append(fila);

            }).always(function(){
				$.unblockUI();
			}).fail(function(){
                $.unblockUI();
				console.log('existe un error ')
			});
        }

        function cargarOperativosEditar(id,idAsistencia,$fecha){
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{route('buscarPersonalOperativoFormularioEditar')}}", { vehiculo: id,fecha:fecha })
            .done(function( data ) {
                var fila;
                var palabraClave;
                $.each(data, function(i, item) {
                    palabraClave=item.split('--')
					fila+='<option value="'+idAsistencia+'-'+palabraClave[2]+'"><strong>'+palabraClave[1] + ' : '+ palabraClave[0]+'</strong></option>'
				});
                $('#operativos_'+id).append(fila);

            }).always(function(){
				$.unblockUI();
			}).fail(function(){
                $.unblockUI();
				console.log('existe un error ')
			});
        }
        function cargarParamedicoEditar(id){
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{route('buscarPersonalParamedicoFormularioEditar')}}", { vehiculo: id, fecha:fecha})
            .done(function( data ) {
                var fila;
                var palabraClave;
                fila='<option value="">--Selecione Paramédico--</option>'
                $.each(data, function(i, item) {
                    palabraClave=item.split('--')
					fila+='<option value="'+palabraClave[1]+'"><strong>'+palabraClave[0]+'</strong></option>'
				});
                $('#paramedico_'+id).append(fila);

            }).always(function(){
				$.unblockUI();
			}).fail(function(){
                $.unblockUI();
				console.log('existe un error ')
			});
        }
        $('#paramedico_'+id).select2({
            placeholder: 'Seleccione paramedicos',

        });
        $('#operativos_'+id).select2({
            placeholder: 'Seleccione  acompañantes'
        });
        $('#operador_'+id).select2();

    }
    $('#formEditarUsuario').submit(function (event) {
        cargarGif();
    })

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
              zoom: 15,

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
                         // des aki para ver
                         @if( $formulario->puntoReferencia_id )
                         var latitud={{$formulario->puntoReferencia->latitud}};
                        var longitud={{$formulario->puntoReferencia->longitud}};
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
                    @endif
                @endforeach
            @endif

            document.getElementById('puntoRe').addEventListener('change', function() {
                var id=document.getElementById('puntoRe').value;
                var selectedMode = "DRIVING";
                if(id){
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
                }else{
                    initMap()
                }


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
