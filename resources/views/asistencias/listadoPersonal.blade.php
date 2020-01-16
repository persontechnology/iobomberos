
@extends('layouts.app',['title'=>'Lista de personal'])
@section('breadcrumbs', Breadcrumbs::render('listadoPersonalAsistencia',$estacion))

@section('barraLateral')

    <div class="breadcrumb justify-content-center">
        <a href="{{ route('exportPdfAsistencia',$asistencia->id) }}" target="_blanck" class="breadcrumb-elements-item" data-toggle="tooltip" data-placement="bottom" title="Exportar asistencia de {{ $estacion->nombre }} a PDF del día de hoy">
            <i class="far fa-file-pdf"></i>
            Exportar PDF
        </a>    
        <a href="{{ route('buscarAsistencia',$estacion->id) }}" class="breadcrumb-elements-item" data-toggle="tooltip" data-placement="bottom" title="Buscar asistencia por fecha de {{ $estacion->nombre }}">
            <i class="fas fa-search"></i>
            Buscar asistencia
        </a>
    </div>
@endsection
@section('content')

@if($asistencia->fecha<=$asistencia->fechaFin)
<div class="alert alert-info alert-styled-left alert-dismissible">
    
    <span class="font-weight-semibold">Regitro de asistencia creado {{ $asistencia->created_at }} {{ $asistencia->created_at->diffForHumans() }}
        culmina el {{ $asistencia->fechaFin }}    
    </span> 
</div>
@endif

<div class="container-fluid">
    <small id="mensaje" class=""></small>
    <div class="row">
        <div class="col-md-6">

            @if (count($personales))
                <div class="card">
                    <div class="card-header">
                        Listado de personal 123
                    </div>
                    <div class="card-body">
                        <div class="list-cards">  
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Personal</th>
                                        <th scope="col">Asistencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($p=0)
                                        @foreach ($personales as $personal)
                                        @php($p++)
                                            <tr>
                                                <th scope="row">
                                                    {{ $p }}
                                                </th>
                                                <td>
                                                    @if (Storage::exists($personal->foto))
                                                        <a href="{{ Storage::url($personal->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
                                                            <img src="{{ Storage::url($personal->foto) }}" alt="" class="img-fluid" width="45px;">
                                                        </a>
                                                    @else
                                                        <img src="{{ asset('img/user.png') }}" alt="" class="img-fluid" width="45px;">
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $personal->name }}
                                                    @if (count($personal->getRoleNames())>0)
                                                    <small class="badge badge-light float-right">
                                                        @foreach ($personal->getRoleNames() as $rol)
                                                        {{ $rol }},
                                                        @endforeach
                                                    </small>    
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    <input type="checkbox" data-url="{{ route('estadoAsistenciaPersonal',$personal->asistenciaPersonal->id) }}" data-id="u_{{ $personal->asistenciaPersonal->id }}" value="{{ $personal->asistenciaPersonal->id }}" class="toggle-estado" {{ $personal->asistenciaPersonal->estado==true?'checked':'' }} data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="warning" data-size="xs">  
                                                    <input type="text" value="{{ $personal->asistenciaPersonal->observacion }}" onkeyup="detalle(this)" data-url="{{ route('obsAsistenciaPersonal') }}" data-id="{{ $personal->asistenciaPersonal->id }}"  style="{{ $personal->asistenciaPersonal->estado==true?'display: none':'' }}" class="form-control form-control-sm mt-1" id="u_{{ $personal->asistenciaPersonal->id }}" placeholder="Observacíon">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>No existe personales</strong>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            @if (count($vehiculos))
                <div class="card">
                    <div class="card-header">
                        Listado de vehículos
                    </div>
                    <div class="card-body">
                    <div class="list-cards">  
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Vehículo</th>
                                    <th scope="col">Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($v=0)
                                    @foreach ($vehiculos as $vehiculo)
                                    @php($v++)
                                        <tr>
                                            <th scope="row">
                                                {{ $v }}
                                            </th>
                                            <td>
                                                @if (Storage::exists($vehiculo->foto))
                                                    <a href="{{ Storage::url($vehiculo->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
                                                        <img src="{{ Storage::url($vehiculo->foto) }}" alt="" class="img-fluid" width="45px;">
                                                    </a>
                                                @else
                                                    <img src="{{ asset('img/user.png') }}" alt="" class="img-fluid" width="45px;">
                                                @endif
                                            </td>
                                            <td>
                                                    {{ $vehiculo->tipoVehiculo->nombre }} <strong>{{ $vehiculo->tipoVehiculo->codigo }}-{{ $vehiculo->codigo }} </strong>
                                                <small class="badge badge-light float-right">{{ $vehiculo->placa }}</small>
                                            </td>
                                            <td>
                                                <input type="checkbox" data-url="{{ route('estadoAsistenciaVehiculo',$vehiculo->asistenciaVehiculo->id) }}" data-id="v_{{ $vehiculo->asistenciaVehiculo->id }}" value="{{ $vehiculo->asistenciaVehiculo->id }}" class="toggle-estado" {{ $vehiculo->asistenciaVehiculo->estado==true?'checked':'' }} data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="warning" data-size="xs">  
                                                <input type="text" value="{{ $vehiculo->asistenciaVehiculo->observacion }}" onkeyup="detalle(this)" data-url="{{ route('obsAsistenciaVehiculo') }}" data-id="{{ $vehiculo->asistenciaVehiculo->id }}" style="{{ $vehiculo->asistenciaVehiculo->estado==true?'display: none':'' }}" class="form-control form-control-sm mt-1" id="v_{{ $vehiculo->asistenciaVehiculo->id }}" placeholder="Observacíon">
                                                

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>No existe vehiculos</strong>
                </div>
            @endif
        </div>
    </div>
</div>



@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plus/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('admin/plus/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

{{--  toogle  --}}
<link href="{{ asset('admin/plus/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/plus/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
@endpush
    


@prepend('linksPie')
    <script>
        
        $('#menuGenerarAsistencia').addClass('active');

        $('.toggle-estado').change(function() {

            var iden=$(this).data('id');
            var valor=$(this).val();
            var url=$(this).data('url');

            estado=$(this).prop('checked')
            if(estado){
                $('#'+iden).hide();
            }else{
                $('#'+iden).show();
            }
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post(url,{id:valor})
            .done(function(data) {
                if(data.success){
                    $('#mensaje').html(data.success)
                }
            })
            .fail(function(error) {
                
            })
            .always(function() {
                $.unblockUI();
            });
        });



        function detalle(arg){
            var id=$(arg).data('id');
            var url=$(arg).data('url');
            var detalle=$(arg).val();
            $.post(url, { id:id,detalle:detalle})
            .done(function( data ) {
                if(data.success){
                    $('#mensaje').html(data.success)
                }
            }).always(function(){
                
            }).fail(function(err){
                
            });
        }

        $('.table').DataTable({
            "lengthChange": false,
            "paging": false,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
        
    </script>
    <style>
            .list-cards {
                overflow: auto;
                max-height: 450px;
                width: auto;
            }
            .ista{
                overflow-y: auto;
            }
            .stiloitems{
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 10px;
                background-color: #F5F5F5;
                
            }
            .stiloitems1:active{
                -webkit-box-shadow: inset 0 0 6px rgba(237, 23, 12);
                border-radius: 10px;
                background-color: #F5F5F5;
                
            }
                
        </style>
@endprepend
@endsection
