@extends('layouts.app')

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
        <h3 class="text-center"><strong>INFORME N° {{ $formu->numero }} DEL EVENTO ADEVRSO</strong></h3>

    </div>
    <div class="card-body">
        <h6><strong>1.- TIPO DE EMERGENCIA</strong></h6>
        Emergencia: <strong>{{ $formu->emergencia->nombre }}</strong>
        <br>
        @if (count($formu->emergencia->tipos)>0)
        <div class="border">
            @foreach ($formu->emergencia->tipos as $tipoEme)
                <div class="form-check form-check-inline ml-1">
                    <input class="form-check-input" type="checkbox" name="tipoEmergencia" id="tipoEme_{{ $tipoEme->id }}" value="{{ $tipoEme->id }}">
                    <label class="form-check-label" for="tipoEme_{{ $tipoEme->id }}">
                        {{ $tipoEme->nombre }}
                    </label>
                </div>
            @endforeach
        </div>
        @else
            <div class="alert alert-danger" role="alert">
                <strong>Está emergencia no tiene tipos</strong>
            </div>
        @endif
        <h6 class="mt-1"><strong>2.- INFORMACIÓN GENERAL.</strong></h6>
        <div class="border">
            Fecha: <strong>{{ $formu->fecha }} (solo fecha)</strong>  Fecha de aviso del incidente: <strong>{{ $formu->fecha }} (solo hora)</strong>
            Hora de salida: <strong>{{ $formu->horaSalida }}</strong><br>
            Hora de Arrivo del Incidente: <strong>{{ $formu->horaEntrada}}</strong> Lugar de Incidente: <strong>{{ $formu->puntoReferencia->barrio->nombre.' '.$formu->puntoReferencia->referencia }}</strong>
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

        <div id="cargarPersonalUnidades">
            
        </div>
        <br>
        @can('comprobarAtensionHospitalaria', $formu)
            <button class="btn btn-primary"> Crear fichas medica</button>
        @endcan
        @can('comprobarContraIncendio', $formu)
        <h6 class="mt-1"><strong>4.- ETAPAS DE INCENDIO Y EDIFICACIÓN.</strong></h6>
        <div class="border">
            @if($formu->etapaIncendio&& $formu->edificacion)
            
            <table class="table-border text-center">
                <tr>
                    <th colspan="6">
                            <h6 class="mt-1"><strong> ETAPAS DE INCENDIO.</strong></h6>
                    </th>
                </tr>
                <tr>
                    <th>
                        Incipiente
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->incipiente==true?'checked':''  }} name="" id="">
                    </th>
                    <th>
                        Desarrollo
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->desarrollo==true?'checked':''  }} name="" id="">

                    <th>
                        Combustión libre
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->combustion==true?'checked':''  }} name="" id="">
  
                    <th>
                        Flashover
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->flashover==true?'checked':''  }} name="" id="">
  
                    <th>
                        Decadencia
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->decadencia==true?'checked':''  }} name="" id="">

                    <th>
                        Arder sin llama
                        <input class="mt-1" type="checkbox" {{$formu->etapaIncendio->arder==true?'checked':''  }} name="" id="">
                    </th>
                       

                </tr>
            </table>
            <br>
            <table class="table-border text-center">
                    <tr>
                        <th colspan="6">
                                <h6 class="mt-1"><strong> EDIFICACIÓN.</strong></h6>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Tipo de construción    
                        </th>
                        <th>
                            Madera
                            <input class="mt-1" type="checkbox" {{$formu->edificacion->madera==true?'checked':''  }} name="" id="">
                        </th>
                        <th>
                            Hormigón
                            <input class="mt-1" type="checkbox" {{$formu->edificacion->hormigon==true?'checked':''  }} name="" id="">
                        </th>
                        <th>
                            Mixta
                            <input class="mt-1" type="checkbox" {{$formu->edificacion->mixta==true?'checked':''  }} name="" id="">
                        </th>
                        <th>
                            Metálica
                            <input class="mt-1" type="checkbox" {{$formu->edificacion->metalica==true?'checked':''  }} name="" id="">
                        </th>
                        <th>
                            Adobe
                            <input class="mt-1" type="checkbox" {{$formu->edificacion->adobe==true?'checked':''  }} name="" id="">
                        </th>                          
    
                    </tr>

                    <tr>
                            <th>
                                Númerp de plantas  
                            </th>
                            <th>
                                Planta baja
                                <input class="mt-1" type="checkbox" {{$formu->edificacion->plantaBaja==true?'checked':''  }} name="" id="">
                            </th>
                            <th>
                                1 Planta
                                <input class="mt-1" type="checkbox" {{$formu->edificacion->primerPiso==true?'checked':''  }} name="" id="">
                            </th>
                            <th>
                                2 Planta
                                <input class="mt-1" type="checkbox" {{$formu->edificacion->segundoPiso==true?'checked':''  }} name="" id="">
                            </th>
                            <th>
                                3 Planta
                                <input class="mt-1" type="checkbox" {{$formu->edificacion->tercerPiso==true?'checked':''  }} name="" id="">
                            </th>
                            <th>
                                Patio
                                <input class="mt-1" type="checkbox" {{$formu->edificacion->patio==true?'checked':''  }} name="" id="">
                            </th>                          
        
                        </tr>
                </table>

            @else
            <button type="button" class="btn btn-primary" onclick="crearEtapas(this);">
                    CREAR ETAPAS DE INCENDIO Y EDIFICACIÓN
            </button>
            @endif
            
        </div>
            
        @endcan

    </div>
    <div class="card-footer text-muted">
        Footer
    </div>
</div>




@push('linksCabeza')
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
        
        $('#menuEscritorio').addClass('active');

        // cargara personal y unidades despachadas --> paso 3
        
        $("#cargarPersonalUnidades").load("{{ route('cargarPersonalUnidadesDespachadas',$formu->id) }}", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                console.log('ok')
            }
              
            if(statusTxt == "error"){
                notificar('error','NO se pudo cargar personal y unidades depachadas');
            }
            
          });
    </script>
    
    <script>
            function crearEtapas(){
                var url="{{ route('crearEdificacionFormulario') }}";
                var id="{{ $formu->id }}";
                swal({
                    title: "¿Estás seguro?",
                    text: "Que desea crear crear etapas de incendio y edificación.!",
                    type: "info",
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
                    $.post( url, { formulario: id })
                    .done(function( data ) {
                        
                       location.replace("{{ route('completarFormulario',$formu->id) }}");
                    }).always(function(){
                        $.unblockUI();
                    }).fail(function(){
                        notificar("error","Ocurrio un error");
                    });
        
                });
            }
        </script>
@endprepend
@endsection
