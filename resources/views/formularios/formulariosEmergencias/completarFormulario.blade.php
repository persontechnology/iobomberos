@extends('layouts.app',['title'=>'Completar formulario '])
@section('breadcrumbs', Breadcrumbs::render('completarFormulario',$formu))

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
        <h3 class="text-center"><strong>INFORME N° {{ $formu->numero }} DEL EVENTO ADVERSO</strong></h3>

    </div>
    <form action="{{ route('completar-informacion') }}" method="post" enctype="multipart/form-data" id="formCompletar">
        @csrf
        <input type="hidden" value="{{$formu->id }}" name="formulario" id="formulario">
        <div class="card-body">
            <h6><strong>1.- TIPO DE EMERGENCIA</strong></h6>
            Emergencia: <strong>{{ $formu->emergencia->nombre }}</strong>
            <br>            
            @if (count($formu->emergencia->tipos)>0)
        
                <div class="form-group row mt-1">
                    <label for="inputEmail3" class="col-sm-3 col-form-label"><strong> Seleccione el tipo de emergencia </strong></label>
                    <div class="col-sm-9">
                        <select class="form-control @error('tipoEmergencia') is-invalid @enderror" required name="tipoEmergencia"  id="tipoEmergencia" data-live-search="true">
                            <option value="">---Seleccione un tipo de emergencia---</option>
                            @foreach ($formu->emergencia->tipos as $tipoEme)
                                <option value="{{$tipoEme->id}}" {{ old('tipoEmergencia',$formu->tipoEmergencia_id)==$tipoEme->id?'selected':''  }}>{{$tipoEme->nombre}}</option> 
                            @endforeach
                        </select>
                        @error('tipoEmergencia')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
                    </div>
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
                Hora de Arrivo del Incidente: <strong>
                    <input type="time" name="horaEntrada" id="horaEntrada" required value="{{ old('horaEntrada',$formu->horaEntrada)}}" class="form-control form-control-sm @error('horaEntrada') is-invalid @enderror" >
                    @error('horaEntrada')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </strong> Lugar de Incidente:  
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
                    <div class="border" id="edificaciones">           
                
                    </div> 
                    <h6 class="mt-1"><strong>4.- CARACTERISTICAS DEL INCENDIO (FORESTAL) .</strong></h6>
                    <div class="border" id="forestal">           
                
                    </div>            
                @endcan            
            @can('comprobarAtensionHospitalaria', $formu)
                @if ($formu->tipoEmergencia_id)
                    <a href="{{ route('atenciones',$formu->id) }}" class="btn btn-primary text-white"> Crear fichas médicas</a>
                    
                @else
                    <div class="alert alert-info" role="alert">
                        Para crear las fichas Pre-Hospitalarias debe primero actualizar el formulario
                    </div>
                @endif
            @elsecan('noPreospitalario', $formu)
            <h6 class="mt-1"><strong>5.- ORIGEN Y CAUSAS DEL EVENTO.</strong></h6>
            <textarea class="form-control @error('origenCausa') is-invalid @enderror" name="origenCausa" id="origenCausa" cols="20" required rows="5"> {{ old('origenCausa',$formu->origenCausa) }}</textarea>
            @error('origenCausa')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <h6 class="mt-1"><strong>6.- TRABAJO REALIZADO.</strong></h6>  
            <textarea class="form-control @error('tabajoRealizado') is-invalid @enderror" name="tabajoRealizado" id="tabajoRealizado" cols="20" required rows="10">{{ old('tabajoRealizado',$formu->tabajoRealizado) }}</textarea>
            @error('tabajoRealizado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <h6 class="mt-1"><strong>7.- RECURSOS UTILIZADOS.</strong></h6>
                <div id="materialesFormulario">

                </div>
            <h6 class="mt-1"><strong>8.- DAÑOS OCASIONADOS.</strong></h6>
            <div id="daniosFormulario">

            </div>
            <h6 class="mt-1"><strong>9.- NÚMERO DE HERIDOS.</strong></h6>
            <input type="number" class="form-control @error('numeroHeridos') is-invalid @enderror" id="numeroHeridos" name="numeroHeridos" value="{{ old('numeroHeridos',$formu->heridos) }}">
            @error('numeroHeridos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <h6 class="mt-1"><strong>10.- ANEXOS FOTOGRÁFICOS.</strong></h6>
            <div id="cargarAnexos">
                
            </div>
            <input type="file" id="foto" name="foto[]" multiple>
        </div>
        @endcan
        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Guardar ficha</button>
        </div>
            
    </form>
        
    
</div>
@push('linksCabeza')
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>
<script src="{{ asset('admin/plus/bootstrap-fileinput/js/locales/es.js') }}"></script>

<link rel="stylesheet" href="{{ asset('admin/plus/select/css/bootstrap-select.min.css') }}">
<script src="{{ asset('admin/plus/select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admin/plus/select/js/lg/defaults-es_ES.min.js') }}"></script>
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
         $('select').selectpicker();
         $('#menuMisFormularios').addClass('active');

        $("#foto").fileinput({           
            rtl: true,
            showUpload: false,
            dropZoneEnabled: false,
            maxFileCount: 10,
            mainClass: "input-group-lg",
            dropZoneEnabled: false,
            allowedFileExtensions: ["jpg", "png", "gif"],
            theme:'fas',
            language:'es',
        })
        // cargara personal y unidades despachadas --> paso 3
        
        $("#cargarPersonalUnidades").load("{{ route('cargarPersonalUnidadesDespachadas',$formu->id) }}", function(responseTxt, statusTxt, xhr){
            cargarGif();
            if(statusTxt == "success"){
                $.unblockUI();
            }              
            if(statusTxt == "error"){
                $.unblockUI();
                notificar('error','NO se pudo cargar personal y unidades depachadas');
            }            
          });
        function cargarMateriales() {
              
          $("#materialesFormulario").load("{{ route('materiales-formulario',$formu->id) }}", function(responseTxt, statusTxt, xhr){
            cargarGif();
                if(statusTxt == "success"){
                    $.unblockUI();
                }              
                if(statusTxt == "error"){
                    $.unblockUI();
                    notificar('error','NO se pudo cargar materiales del formulario');
                }            
          });
        }
          cargarMateriales();
          //funcion para enviar los datos del formulario de materiales
          function cargarDanios() {
              
              $("#daniosFormulario").load("{{ route('danios-formulario',$formu->id) }}", function(responseTxt, statusTxt, xhr){
                cargarGif();
                    if(statusTxt == "success"){
                        $.unblockUI();
                    }              
                    if(statusTxt == "error"){
                        $.unblockUI();
                        notificar('error','NO se pudo cargar materiales del formulario');

                    }            
              });
            }
            cargarDanios();
            function cargarAnexos() {
              
              $("#cargarAnexos").load("{{ route('cambiar-anexos-formulario',$formu->id) }}", function(responseTxt, statusTxt, xhr){
                cargarGif();
                    if(statusTxt == "success"){
                        $.unblockUI();                        
                    }              
                    if(statusTxt == "error"){
                        $.unblockUI();
                        notificar('error','NO se pudo cargar los anexos del formulario');
                    }            
              });
            }
            cargarAnexos();
            //listado de eddificaciones 
            
            function cargarEdificaciones() {
                
            $("#edificaciones").load("{{ route('lista-edificaciones-formulario',$formu->id) }}", function(responseTxt, statusTxt, xhr){
                cargarGif();
                    if(statusTxt == "success"){
                        $.unblockUI();
                        
                    }              
                    if(statusTxt == "error"){
                        $.unblockUI();
                        notificar('error','NO se pudo cargar las edificaciones del formulario');
                    }            
              });
            
            }

            
            cargarEdificaciones();
            function cargarTipoIncendioForestal() {
                
                $("#forestal").load("{{ route('incendio-forestal-formularios',$formu->id) }}", function(responseTxt, statusTxt, xhr){
                    cargarGif();
                        if(statusTxt == "success"){
                            $.unblockUI();
                            
                        }              
                        if(statusTxt == "error"){
                            $.unblockUI();
                            notificar('error','NO se pudo cargar los tipos de incendio forestal del formulario');
                        }            
                  });
                
                }
                cargarTipoIncendioForestal();
            $("#formCompletar").submit(function(event) {
                cargarGif();
            });
            
    </script>
@endprepend
@endsection
