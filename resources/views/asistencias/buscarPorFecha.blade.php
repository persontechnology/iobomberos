@extends('layouts.app',['title'=>'Buscar asistencia por fecha'])
@section('breadcrumbs', Breadcrumbs::render('buscarAsistencia',$estacion))
@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{ route('buscarAsistencia',$estacion->id) }}" method="get">
            <div class="input-group mb-3">
                <input type="date" name="fecha" value="{{ $fecha??'' }}" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Buscar asistencia</button>
                </div>
            </div>
        </form>
    </div>
    
</div>

@if ($asistencia)
    
    <a href="{{ route('exportPdfAsistencia',$asistencia->id) }}" target="_blanck" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Exportar asistencia">
        <i class="far fa-file-pdf"></i>
        Exportar PDF
    </a>
    <div class="row">
        
        <div class="col-md-6">
            @if (count($asistencia->asistenciaPersonal)>0)
                <div class="card">
                    <div class="card-header bg-dark">
                        Listado de personal
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
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
                                    @foreach ($asistencia->asistenciaPersonal as $personal)
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
                                                @if ($personal->asistenciaPersonal->estado==true)
                                                    <p class="text-success"><strong>SI</strong></p>

                                                @else
                                                    <p><strong class="text-danger">NO</strong> <small>{{ $personal->asistenciaPersonal->observacion }}</small></p>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            @if (count($asistencia->asistenciaVehiculo)>0)
                <div class="card">
                    <div class="card-header bg-dark">
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
                                    @foreach ($asistencia->asistenciaVehiculo as $vehiculo)
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
                                                @if ($vehiculo->asistenciaVehiculo->estado==true)
                                                    <p><strong class="text-success">SI</strong></p>
                                                @else
                                                    <p><strong class="text-danger">NO</strong> <small>{{ $vehiculo->asistenciaVehiculo->observacion }}</small></p>
                                                @endif
                                                
                                                

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
@else
<div class="alert alert-warning" role="alert">
    <strong>No existe asistencia en fecha: {{ $fecha }}</strong>
</div>
@endif

   

@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plus/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('admin/plus/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@prepend('linksPie')
    <script>
        
        $('#menuEscritorio').addClass('active');

        $('.table').DataTable({
            "lengthChange": false,
            "scrollY": "400px",
            "scrollCollapse": true,
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

    
@endprepend
@endsection
