@extends('layouts.app',['title'=>'Buscar asistencia por fecha'])
@section('breadcrumbs', Breadcrumbs::render('buscarAsistencia',$estacion))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <form action="{{ route('buscarAsistencia',$estacion->id) }}" method="get">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="date" name="fecha" value="{{ $fecha??'' }}" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="submit">Buscar asistencia</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            <div class="card">
                <div class="card-body">
                    @if($asistencia)
                    <a href="{{ route('exportPdfAsistencia',$asistencia->id) }}" target="_blanck" class="float-right btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Exportar asistencia">
                        <i class="far fa-file-pdf"></i>
                        Exportar PDF
                    </a>  
                    <table style="border-collapse: collapse; border: none;">
                        <td class="noBorder">
                                <img src="{!! public_path('img/escudo.png') !!}" alt="" width="75px;" style="text-align: left;">
                        </td>
                        <td class="noBorder">
                            <h4 style="text-align: center;">
                                CUERPO DE BOMBEROS DE LATACUNGA <br>
                                CONTROL DE ASISTENCIA <br>
                                Fecha: {{ $asistencia->fecha }}<br>
                                Responsable: {{ $asistencia->user->name }} <br>
                                Estación: {{ $asistencia->estacion->nombre }}
                            </h4>
                        </td>
                        <td class="noBorder">
                            
                            <img src="{!! public_path('img/ecuador.png') !!}" alt="" width="75px;" style="text-align: right;">
                        </td>
                    </table>
                    @else
                    <p>No existe asistencia en está fecha</p>
                    @endif
                    @if (count($personales)>0)
                        <p>Listado de personal</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
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
                                            {{ $personal->name }}
                                            <small class="badge badge-light float-right">Admin</small>
                                        </td>
                                        <td>
                                            
                                            @if ($personal->asistenciaPersonal->estado==true)
                                                SI
                                            @else
                                                <strong style="color: red;">NO </strong> 
                                                <small>
                                                        {{ $personal->asistenciaPersonal->observacion }}
                                                </small>
                                            @endif

                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if (count($vehiculos)>0)
                    <p>Listado de vehículos</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
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
                                            {{ $vehiculo->tipoVehiculo->nombre }} <strong>{{ $vehiculo->tipoVehiculo->codigo }}-{{ $vehiculo->codigo }} </strong>
                                        <small class="badge badge-light float-right">{{ $vehiculo->placa }}</small>
                                    </td>
                                    <td>
                                        @if ($vehiculo->asistenciaVehiculo->estado==true)
                                            SI
                                        @else
                                        <strong style="color: red;">NO </strong>
                                            <small>
                                                {{ $vehiculo->asistenciaVehiculo->observacion }}
                                            </small>
                                        @endif
                                        
                                        

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@prepend('linksPie')
    <script>
        
        $('#menuEscritorio').addClass('active');
        
    </script>
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
        </style>
    
@endprepend
@endsection
