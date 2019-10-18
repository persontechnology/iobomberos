<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asistencia</title>

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
</head>
<body>

    @if ($asistencia)
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

        @if (count($asistencia->asistenciaPersonal)>0)
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
                    @foreach ($asistencia->asistenciaPersonal as $personal)
                    @php($p++)
                        <tr>
                            <th scope="row">
                                {{ $p }}
                            </th>
                        
                            <td>
                                {{ $personal->name }}
                                @if (count($personal->getRoleNames())>0)
                                <small class="badge badge-light float-right iz">
                                    @foreach ($personal->getRoleNames() as $rol)
                                    {{ $rol }},
                                    @endforeach
                                </small>    
                                @endif
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
        @if (count($asistencia->asistenciaVehiculo)>0)
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
                @foreach ($asistencia->asistenciaVehiculo as $vehiculo)
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

    @else
        
    @endif
    
    
       
</body>
</html>