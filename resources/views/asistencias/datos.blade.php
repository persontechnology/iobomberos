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
    @if (count($personales))
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
    @else
        <p>No existe personales</p>
    @endif
    @if (count($vehiculos))
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
    @else
        <div class="alert alert-warning" role="alert">
            <strong>No existe vehiculos</strong>
        </div>
    @endif