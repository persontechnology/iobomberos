<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultas</title>
    <link href="{{ asset('admin/font/fontawesome-free-5.9.0-web/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="card">       
  
            @if ($variable>0)
            @if ($operador->count()>0)                
                <div class="card">                    
                   
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center bg-dark">
                                <th colspan="3">Formularios como operador</th>
                            </tr>
                            <tr>
                                <th>Formulario</th>
                                <th>Estación</th>
                                <th>Vehículo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operador as $operador)
                            <tr>    
                            <td>Emergencia:{{$operador->vehiculoEstacion->estacionFormulario->formulario->emergencia->nombre}}
                                    <br>
                                    Formulario N°:{{$operador->vehiculoEstacion->estacionFormulario->formulario->numero}}
                                    <br>
                                    Estado:{{$operador->vehiculoEstacion->estacionFormulario->formulario->estado}}
                                </td>
                                <td>{{$operador->vehiculoEstacion->estacionFormulario->estacion->nombre}}</td>
                                <td>{{$operador->vehiculoEstacion->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$operador->vehiculoEstacion->asistenciaVehiculo->vehiculo->codigo}}</td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($operativo->count()>0)               
                <div class="card">                   
            
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th colspan="3">Formularios como operativo</th>
                            </tr>
                            <tr>
                                <th>Formulario</th>
                                <th>Estación</th>
                                <th>Vehículo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operativo as $operativo)
                            <tr>
                                <td>Emergencia:{{$operativo->vehiculoEstacion->estacionFormulario->formulario->emergencia->nombre}}
                                    <br>
                                    Formulario N°:{{$operativo->vehiculoEstacion->estacionFormulario->formulario->numero}}
                                    <br>
                                    Estado:{{$operativo->vehiculoEstacion->estacionFormulario->formulario->estado}}
                                </td>
                                <td>{{$operativo->vehiculoEstacion->estacionFormulario->estacion->nombre}}</td>
                                <td>{{$operativo->vehiculoEstacion->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$operador->vehiculoEstacion->asistenciaVehiculo->vehiculo->codigo}}</td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($paramedico->count()>0)                
                <div class="card">
                    
            
                    <table class="table table-bordered table-sm ">
                        <thead>
                            <tr class="text-center bg-info">
                                <th colspan="3">Formularios como paramedico</th>
                            </tr>
                            <tr>
                                <th>Formulario</th>
                                <th>Estación</th>
                                <th>Vehículo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paramedico as $paramedico)
                            <tr>
                                <td>Emergencia:{{$paramedico->vehiculoEstacion->estacionFormulario->formulario->emergencia->nombre}}
                                    <br>
                                    Formulario N°:{{$paramedico->vehiculoEstacion->estacionFormulario->formulario->numero}}
                                    <br>
                                    Estado:{{$paramedico->vehiculoEstacion->estacionFormulario->formulario->estado}}
                                </td>
                                <td>{{$paramedico->vehiculoEstacion->estacionFormulario->estacion->nombre}}</td>
                                <td>{{$paramedico->vehiculoEstacion->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$operador->vehiculoEstacion->asistenciaVehiculo->vehiculo->codigo}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @else
                <div class="alert alert-danger" role="alert">
                    No posee formularios en este día
                </div>
            @endif
    </div>
</body>
</html>