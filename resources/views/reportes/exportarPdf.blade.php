<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportar Reporte</title>
    <style>
        table {
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }
              
        table, th, td {
            border: 1px solid black;
        }
        .mitexarea{
            width: 100%;
        }

        .noBorder {
            border:none !important;
        }
    </style>
    
    <style type="text/css">
        .page {
            overflow: hidden;
            page-break-after: always;
        }
    </style>
    <style type="text/css">
        @media print {
                .element-that-contains-table {
                    overflow: visible !important;
                }
            }

        thead{display: table-header-group;}
        tfoot {display: table-row-group;}
        tr {page-break-inside: avoid;}

    </style>
</head>
<body>
    
    <table  style="border-collapse: collapse; border: none; width: 100%">
        <td class="noBorder">
                <img src="{!! public_path('/img/ecuador.png') !!}" alt="" width="65px;" style="text-align: left;">
        </td>
        <td class="noBorder">
            <h3 style="text-align: center;">
                <strong>
                CUERPO DE BOMBEROS DE LATACUNGA <br> 
                REPORTE DE EMERGENCIAS DEL  MES  DE {{$mes}} AÑO <strong>{{date('Y',strtotime($fecha))}}</strong>           
                </strong>
            </h3>
        </td>
        <td class="noBorder">
            
            <img src="{!! public_path('img/escudo.png') !!}" alt="" width="65px;" style="text-align: right;">
        </td>
    </table>
        @if ($formularios->count()>0)
        
        <div >
            <table class="" style="width: 100%">
                <thead>
                    <tr >
                        <th style="text-align:center" colspan="4">INFORMACIÓN GENERAL</th>
                        <th style="text-align:center">CLASIFICACIÓN</th>
                        <th style="text-align:center" colspan="3">TIEMPO</th>
                        <th style="text-align:center">VICTIMAS</th>
                    
                        <th style="text-align:center">RECURSOS</th>
                    </tr>
                    <tr>
                        <th>Cod</th>
                        <th>Día</th>
                        <th>Dirección o lugar</th>
                        <th>Localidad</th>
                        <th>Tipo de EMergencia</th>
                        <th>Hora de Despacho</th>
                        <th>Hora Ingreso</th>
                        <th>Frecuencia</th>
                        <th>Total</th>
                        <th></th>
                        
                    </tr>
                </thead>
           
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($formularios as $formulario)
                        
                    <tr>
                        <td>{{$formulario->numero}}</td>
                        <td>{{date('d',strtotime($formulario->fecha))}}</td>
                        <td>{{$formulario->puntoReferencia_id?$formulario->puntoReferencia->barrio->nombre.' Referencia: '.$formulario->puntoReferencia->referencia:$formulario->localidad}}</td>
                        <td>{{$formulario->localidadEjecutada}}</td>
                        <td>{{$formulario->emergencia->nombre}}</td>
                        <td>{{$formulario->horaSalida}}</td>
                        <td>{{$formulario->horaEntrada}}</td>
                        <td>{{$formulario->frecuencia}}</td>
                        <td>{{$formulario->heridos}}</td>
                        <td style="text-align:left">
                            <ul>
                            @foreach ($formulario->estacionFormularioEmergencias as $estacion)
                            
                            <li> {{ $estacion->estacion->nombre }}
                                <br>
                                
                                    @foreach ($estacion->formularioEstacionVehiculo as $vehiculo)
                                
                                        <strong>
                                            {{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo.''.$vehiculo->asistenciaVehiculo->vehiculo->codigo}},
            
                                        </strong>
                                    
                                    @endforeach
                                </ul>
                            </li>
                        
                                
                            @endforeach
                        </ul>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
             
            </table>
        </div>
        @else
        <div class="alert alert-danger" role="alert">
            No existen datos registros
        </div>
        @endif
        
  
</body>
</html>