
@extends('layouts.app',['title'=>'Lista de personal'])
@section('breadcrumbs', Breadcrumbs::render('listadoPersonalAsistencia',$estacion))
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">

            @if (count($personales))
                <div class="card">
                    <div class="card-header">
                        Listado de personal
                    </div>
                    <div class="card-body">
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
                                                    <small class="badge badge-light float-right">Admin</small>
                                                </td>
                                                <td>
                                                    <input type="checkbox" data-url="{{ route('estadoAsistenciaPersonal',$personal->asistenciaPersonal->id) }}" data-id="u_{{ $personal->asistenciaPersonal->id }}" value="{{ $personal->asistenciaPersonal->id }}" class="toggle-estado" {{ $personal->asistenciaPersonal->estado==true?'checked':'' }} data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="warning" data-size="xs">  
                                                    <input type="text" style="{{ $personal->asistenciaPersonal->estado==true?'display: none':'' }}" class="form-control form-control-sm mt-1" id="u_{{ $personal->asistenciaPersonal->id }}" placeholder="Observacíon">
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
            @if (count($vehiculos))
                <div class="card">
                    <div class="card-header">
                        Listado de vehículos
                    </div>
                    <div class="card-body">
                        
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
                                                <input type="text" style="{{ $vehiculo->asistenciaVehiculo->estado==true?'display: none':'' }}" class="form-control form-control-sm mt-1" id="v_{{ $vehiculo->asistenciaVehiculo->id }}" placeholder="Observacíon">
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
            
            $.post(url,{id:valor})
            .done(function(data) {
                console.log(data)
            })
            .fail(function(error) {
                
            })
            .always(function() {
                
            });
        });



        function detalle(arg){
            var asis=$(arg).data('asis');
            var detalle=$(arg).val();
            $.post("{{ route('actualizarDetalleAsistencia') }}", { asis:asis,detalle:detalle})
            .done(function( data ) {
                if(data.success){
                    $('#msg_detalle_'+asis).addClass('text-success');
                    $('#msg_detalle_'+asis).html('Guardado exitosamente');
                }
                if(data.default){
                    $('#msg_detalle_'+asis).addClass('text-danger');
                    $('#msg_detalle_'+asis).html(data.default);
                }
                
            }).always(function(){
                
            }).fail(function(){
                $('#msg_detalle_'+asis).addClass('text-danger');
                $('#msg_detalle_'+asis).html('Ocurrio un error');
            });
        }
        
    </script>
    
@endprepend
@endsection
