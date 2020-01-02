
<div class="continer">
        <div class="card-header">
            <table  style="border-collapse: collapse; border: none; width: 100%">
                <td class="noBorder">
                        <img src="{{ asset('img/ecuador.png') }}" alt="" width="45px;" style="text-align: left;">
                </td>
                <td class="noBorder">
                    <h3 style="text-align: center;">
                        <strong>
                        CUERPO DE BOMBEROS DE LATACUNGA <br>
                        UNIDAD DE OPERACIONES <br>
                        </strong>
                    </h3>
                </td>
                <td class="noBorder">
                    
                    <img src="{{ asset('img/escudo.png') }}" alt="" width="45px;" style="text-align: right;">
                </td>
            </table>
            <p style="text-align: right">Latacunga, {{ Carbon\Carbon::parse($formulario->fecha)->format('d-m-Y') }}</p>
            <p>
                {{ $formulario->maximaAutoridad->name }} <br>  
                
                <strong>JEFE DE CUERPO DE LATACUNGA </strong> <br>
                Presente:
            </p>
            <h4 style="text-align: center"><strong>INFORME N° {{ $formulario->numero }} DEL EVENTO ADVERSO</strong></h4>
    
        </div>
        <p><strong>1.- TIPO DE EMERGENCIA</strong><br>
            Emergencia: <strong>{{ $formulario->emergencia->nombre }}</strong><br>
            Tipo de Emergencia: <strong>{{ $formulario->tipoEmergencia_id?$formulario->tipoEmergencia->nombre:'No existe' }}</strong> </p>
        <p class="mt-1"><strong>2.- INFORMACIÓN GENERAL.</strong></p>
            <div style="font-size: 12px;border: 1px;">
                Fecha: <strong>{{\Carbon\Carbon::parse($formulario->fecha)->format('d/m/Y')  }}</strong>  Hora de aviso del incidente: <strong>{{ $formulario->horaSalida }} </strong>
                Hora de salida: <strong>{{ $formulario->horaSalida }}</strong><br>
                Hora de Arrivo del Incidente: <strong> {{ $formulario->horaEntrada}}
                    
                </strong> 
                Lugar de Incidente: <strong> 
                    @if ($formulario->puntoReferencia_id)
                    {{$formulario->puntoReferencia->barrio->nombre.'-'.$formulario->puntoReferencia->referencia}}
                    @else
                        {{$formulario->localidad}}
                    @endif
                </strong>
                Nombre o Institución que Informa: <strong>{{ $formulario->institucion}}</strong> <br>
                
                Aviso del evento: <strong>{{ $formulario->responsable->hasRole('Radio operador')?'Radio operador':'Personal de guardia' }}</strong>
             
                
                    <label class="form-check-label" for="Teléfonico">
                            Teléfonico
                    </label>
                    <input class="form-check-input" type="checkbox" {{ $formulario->formaAviso=="Teléfonico"?'checked':'' }} name="formaAviso" id="formaAviso" value="Teléfonico">
               
                
                    <label class="form-check-label" for="Personal">
                            Personal
                    </label>
                    <input class="form-check-input" type="checkbox" {{ $formulario->formaAviso=="Personal"?'checked':'' }} name="formaAviso" id="formaAviso" value="Personal">
               
                
            </div>
            <div style="width: 100%;height: 35%">
            <p class="mt-1"><strong>3.- PERSONAL Y UNIDADES DESPACHADAS.</strong></p>

            @foreach ($formulario->estacionFormularioEmergencias as $estaciones)                      
                    
                <table id="nuevaTabla" >
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
                        <tr style="text-align: left;font-size: 12px;" >
                            <th>
                                <strong>{{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->nombre}} <br>
                                    {{$vehiculo->asistenciaVehiculo->vehiculo->tipoVehiculo->codigo}}
                                    {{$vehiculo->asistenciaVehiculo->vehiculo->codigo}}
                                </strong>
                            </th>
                            <th>                                
                                 @if ($vehiculo->vehiculoOperador)
                                        
                                    * {{$vehiculo->vehiculoOperador->asistenciaPersonal->usuario->name}}  
                                         
                                @else                                    
                                    * Operador  no asignado
                                    
                                @endif                

                            </th>
                            <th>
                               
                                @foreach ($vehiculo->vehiculoOperativos as $operativos)                             
                                    * {{$operativos->asistenciaPersonal->usuario->name}} <br>
                                        
                                @endforeach                                
                            </th>
                            <th>
                                          
                                @if ($vehiculo->vehiculoParamedico)
                                       
                                    * {{$vehiculo->vehiculoParamedico->asistenciaPersonal->usuario->name}}   
                                        
                                @else
                                
                                * Paramédico no asignado
                                    
                                @endif
                            </th>
                        </tr>  
                        @endforeach                        
                    </tbody>
                </table>
        @endforeach
    </div>
        @can('comprobarContraIncendio', $formulario)
        <p><strong>4. CARACTERITICAS DEL INCENDIO</strong></p>
        @if ($formulario->tipoEmergencia_id)
            @if ($formulario->tipoEmergencia->nombre=="ESTRUCTURAL")
                @if ($formulario->edificacion && $formulario->etapaIncendio && $formulario->tipoEdificacion)
                    <table id="nuevaTabla">
                        <tr>
                            <th colspan="6">
                                    <h6 class="mt-1"><strong> TIPO DE EDIFICACIÓN.</strong></h6>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Domestico
                                <input class="mt-1" type="checkbox"  name="domestico" id="domestico" {{ old('domestico',$formulario->tipoEdificacion->domestico)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Comercial
                                <input class="mt-1" type="checkbox"  name="comercial" id="comercial" {{ old('comercial',$formulario->tipoEdificacion->comercial)=='1'?'checked':''}}>

                            <th>
                                Industrial
                                <input class="mt-1" type="checkbox"  name="industrial" id="industrial" {{ old('industrial',$formulario->tipoEdificacion->industrial)=='1'?'checked':''}}>

                            <th>
                                Galpones
                                <input class="mt-1" type="checkbox"  name="galpones" id="galpones" {{ old('galpones',$formulario->tipoEdificacion->galpones)=='1'?'checked':''}}>

                        </tr>
                    </table>  
                    <table id="nuevaTabla">
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
                                <input class="mt-1" type="checkbox"  value="1" name="madera" id="madera" {{ old('madera',$formulario->edificacion->madera)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Hormigón
                                <input class="mt-1" type="checkbox"  value="1" name="hormigon" id="hormigon" {{ old('hormigon',$formulario->edificacion->hormigon)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Mixta
                                <input class="mt-1" type="checkbox"  value="1" name="mixta" id="mixta" {{ old('mixta',$formulario->edificacion->mixta)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Metálica
                                <input class="mt-1" type="checkbox"  value="1" name="metalica" id="metalica" {{ old('metalica',$formulario->edificacion->metalica)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Adobe
                                <input class="mt-1" type="checkbox"  value="1" name="adobe" id="adobe" {{ old('adobe',$formulario->edificacion->adobe)=='1'?'checked':'' }}>
                            </th>                          

                        </tr>

                        <tr>
                                <th>
                                    Número de plantas  
                                </th>
                                <th>
                                    Planta baja
                                    <input class="mt-1" type="checkbox"  value="1" name="plantaBaja" id="plantaBaja" {{ old('plantaBaja',$formulario->edificacion->plantaBaja)=='1'?'checked':'' }}>
                                </th>
                                <th>
                                    1 Planta
                                    <input class="mt-1" type="checkbox"  value="1" name="primerPiso" id="primerPiso" {{ old('primerPiso',$formulario->edificacion->primerPiso)=='1'?'checked':'' }}>
                                </th>
                                <th>
                                    2 Planta
                                    <input class="mt-1" type="checkbox"  value="1" name="segundoPiso" id="segundoPiso" {{ old('segundoPiso',$formulario->edificacion->segundoPiso)=='1'?'checked':'' }}>
                                </th>
                                <th>
                                    3 Planta
                                    <input class="mt-1" type="checkbox"  value="1" name="tercerPiso" id="tercerPiso" {{ old('tercerPiso',$formulario->edificacion->tercerPiso)=='1'?'checked':'' }}>
                                </th>
                                <th>
                                    Patio
                                    <input class="mt-1" type="checkbox"  value="1" name="patio" id="patio" {{ old('patio',$formulario->edificacion->patio)=='1'?'checked':'' }}>
                                </th>                          

                            </tr>
                    </table>
                    <table id="nuevaTabla">
                        <tr>
                            <th colspan="6">
                                    <h6 class="mt-1"><strong> ETAPAS DE INCENDIO.</strong></h6>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Incipiente
                                <input class="mt-1" type="checkbox"  name="incipiente" id="incipiente" {{ old('incipiente',$formulario->etapaIncendio->incipiente)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Desarrollo
                                <input class="mt-1" type="checkbox"  name="desarrollo" id="desarrollo" {{ old('desarrollo',$formulario->etapaIncendio->desarrollo)=='1'?'checked':''}}>

                            <th>
                                Combustión libre
                                <input class="mt-1" type="checkbox"  name="combustion" id="combustion" {{ old('combustion',$formulario->etapaIncendio->combustion)=='1'?'checked':''}}>

                            <th>
                                Flashover
                                <input class="mt-1" type="checkbox"  name="flashover" id="flashover" {{ old('flashover',$formulario->etapaIncendio->flashover)=='1'?'checked':''}}>

                            <th>
                                Decadencia
                                <input class="mt-1" type="checkbox"  name="decadencia" id="decadencia" {{ old('decadencia',$formulario->etapaIncendio->decadencia)=='1'?'checked':''}}>

                            <th>
                                Arder sin llama
                                <input class="mt-1" type="checkbox"  name="arder" id="arder" {{ old('arder',$formulario->etapaIncendio->arder)=='1'?'checked':''}}>
                            </th>                           

                        </tr>
                    </table> 
                    @endif 
                @endif
                @if ($formulario->tipoEmergencia->nombre=="FORESTAL")
                @if ($formulario->tipoIncendioForestal && $formulario->etapaIncendioForestal)
                <div style="width: 100%;height: 25%">
                <p class="mt-1"><strong> 4.1. CONDICIONES CLIMÁTICAS</strong>
                    <br>
                    {{ $formulario->condicionClimatica }}
                </p>
                </div>
                
                <p class="mt-1"><strong> 4.2. LOCALIZACION</strong></p>
                
                @if ($formulario->puntoReferencia_id)
                <p class="mt-1"><strong> El incendio forestal se desarrollo en el cantón Latacunga, Parroquia {{ $formulario->puntoReferencia->barrio->parroquia->nombre }}, Barrio {{ $formulario->puntoReferencia->barrio->nombre }}, Sector {{ $formulario->puntoReferencia->referencia }}. Latatitud y Longitud {{ $formulario->puntoReferencia->latitud .','.$formulario->puntoReferencia->longitud }}</strong></p>  
                <div id="map" >
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        no existe punto de referencia
                    </div>
                @endif
                <p class="mt-1"><strong> 4.3. TIPO INCENDIO</strong></p>
                <table id="nuevaTabla" style="font-size: 12px">                          
                        <tr>
                            <th>
                                Agrícola
                                <input class="mt-1" type="checkbox"  name="agricola" id="agricola" {{ old('agricola',$formulario->tipoIncendioForestal->agricola)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Suelo
                                <input class="mt-1" type="checkbox"  name="suelo" id="suelo" {{ old('suelo',$formulario->tipoIncendioForestal->suelo)=='1'?'checked':''}}>
                    
                            <th>
                                Copas
                                <input class="mt-1" type="checkbox"  name="copas" id="copas" {{ old('copas',$formulario->tipoIncendioForestal->copas)=='1'?'checked':''}}>
                    
                            <th>
                                Sub Suelo
                                <input class="mt-1" type="checkbox"  name="subSuelo" id="subSuelo" {{ old('subSuelo',$formulario->tipoIncendioForestal->subSuelo)=='1'?'checked':''}}>
                    
                        </tr>
                    </table>  
                    <p class="mt-1"><strong> 4.4. ETAPAS DEL INCENDIO.</strong></p>
                    <table id="nuevaTabla" style="font-size: 12px">
                       
                        
                        <tr>
                            
                            <th>
                                Iniciación
                                <input class="mt-1" type="checkbox"  value="1" name="iniciacion" id="iniciacion" {{ old('iniciacion',$formulario->etapaIncendioForestal->iniciacion)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Propagación
                                <input class="mt-1" type="checkbox"  value="1" name="propagacion" id="propagacion" {{ old('propagacion',$formulario->etapaIncendioForestal->propagacion)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Estabilizado
                                <input class="mt-1" type="checkbox"  value="1" name="estabilizado" id="estabilizado" {{ old('estabilizado',$formulario->etapaIncendioForestal->estabilizado)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Activo
                                <input class="mt-1" type="checkbox"  value="1" name="activo" id="activo" {{ old('activo',$formulario->etapaIncendioForestal->activo)=='1'?'checked':'' }}>
                            </th>
                            <th>
                                Controlado
                                <input class="mt-1" type="checkbox"  value="1" name="controlado" id="controlado" {{ old('controlado',$formulario->etapaIncendioForestal->controlado)=='1'?'checked':'' }}>
                            </th> 
                            <th>
                                Extinguido
                                <input class="mt-1" type="checkbox"  value="1" name="extinguido" id="extinguido" {{ old('extinguido',$formulario->etapaIncendioForestal->extinguido)=='1'?'checked':'' }}>
                            </th>                         
                    
                        </tr>                 
                        </table>
                    @endif  
                @endif  
            @endif
        @endcan
        @can('comprobarAtensionHospitalaria', $formulario)

        @elsecan('noPreospitalario', $formulario)
        <p class="mt-1"><strong>5.- ORIGEN Y CAUSAS DEL EVENTO.</strong></p>
            <p > {{ $formulario->origenCausa }}</p>            
            <p class="mt-1"><strong>6.- TRABAJO REALIZADO.</strong></p>  
            <p >{{ $formulario->tabajoRealizado }}</>            
            <p class="mt-1"><strong>7.- RECURSOS UTILIZADOS.</strong>
                @if ($formulario->materiales->count()>0)
                <ul class="">
                    @foreach ($formulario->materiales as $material)
                        <li class="media">
                                 {{$material->nombre}}                           
                        </li>
                    @endforeach
                </ul>
                @endif
            </p>
            <p class="mt-1"><strong>8.- DAÑOS OCASIONADOS.</strong>
                @if ($formulario->danios->count()>0)
                    <ul class="">
                        @foreach ($formulario->danios as $danio)
                            <li class="media">                             
                                {{$danio->nombre}}                       
                            </li>
                        @endforeach
                    </ul>
                @endif
            </p>
            <p class="mt-1"><strong>9.- NÚMERO DE HERIDOS.</strong><br>
                {{ $formulario->heridos }}
            </p>
            
            <p class="mt-1"><strong>10.- ANEXOS FOTOGRÁFICOS.</strong></p>
            @if ($formulario->anexos->count()>0)
            
                @php
                    $i=0;
                @endphp               
                    
                @foreach ($formulario->anexos as $anexo)
                    @php
                         $i++;
                    @endphp
                    @if ($i%2==1)
                        
                        <table style="width: 50%;" align="left" class="egt" >
                                    <thead>                                        
                                <tr>
                                <th>
                                    <img  width="100%" height="150px" src="{{ Storage::url($anexo->foto) }}" alt="">
                                    Anexo {{ $i }} 
                                </th>                   
                                </tr>
                            </thead>
                        </table>
                    @else
                    <table style="width: 50%;" align="right" class="egt" >
                        <thead>                                        
                            <tr>
                                <th>
                                    <img  width="100%" height="150px" src="{{ Storage::url($anexo->foto) }}" alt="">
                                    Anexo {{ $i }} 
                                </th>                   
                            </tr>
                        </thead>
                    </table> 
                    @endif
                @endforeach                 
            @endif           
        @endcan
        <p><strong>Firmas</strong></p>
        <table id="nuevaTabla">
            <thead>
                <tr>
                    <th>Elaborado</th>
                    <th>Elaborado</th>
                    <th>Revisado</th>
                </tr>
            </thead>
            <tr>
                <th>    
                    
                        <br>
                        <br>
                        <br>
                        <br>
                        <strong>..................................</strong><br>
                        {{$formulario->asitenciaEncardado->usuario->name??'XXXXXXXXXX'}}<br>
                        <strong> OPERATIVO DEL CBL</strong>                        
                
                </th>
                <th>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                        <strong>..................................</strong><br>
                        <strong> CLASE DE GUARDIA DEL CBL</strong>
                </th>
                <th>
                    <br>
                    <br>
                    <br>
                    <br>
                        <strong>..................................</strong><br>
                        @if ($oficial)
                            {{ $oficial->name }}
                        @else
                            XXXXXXXXX
                        @endif
                        <br>
                        <strong>OFICIAL (E) DE LA UNIDAD DE OPERACIONES </strong>
                </th>
            </tr>
        </table>
</div>
<script>
        var map;
            var marker;
        @if( $formulario->puntoReferencia_id )
            function initMap() {
                @if($formulario->estaciones->count()>0)
                    @foreach($formulario->estaciones as $estacion)
                        var directionsRenderer{{$estacion->id}} = new google.maps.DirectionsRenderer;
                        var directionsService{{$estacion->id}} = new google.maps.DirectionsService;
                    @endforeach
                @endif
                var myLatLng={lat: -0.7945178, lng: -78.62189341068114}
                map = new google.maps.Map(document.getElementById('map'), {
                  center: myLatLng,
                 
                  zoom: 15,
                mapTypeId: 'satellite',
                
                   
                });
                
                var imageEstacion="{{ asset('img/ESTACION1.png') }}";
                var imagePuntos="{{ asset('img/puntos.png') }}";
            
                @if($formulario->estaciones->count()>0)
                    @foreach($formulario->estaciones as $estacion)
                    @if ($estacion->latitud&&$estacion->longitud)
                         
                            var latitu={{$estacion->latitud}};
                            var longi={{$estacion->longitud}};
                            var marker_{{$estacion->id}} = new google.maps.Marker({
                                map: map,
                                position:{lat:latitu , lng:longi } ,
                                title:"{{$estacion->nombre}}",
                                icon:imageEstacion,
                            });
                            
                            var nombre="{{$estacion->nombre}}";
                            var geocoder = new google.maps.Geocoder;
                            var infowindow = new google.maps.InfoWindow;
                            infowindow.setContent(nombre);
                            var latitud={{$formulario->puntoReferencia->latitud}};
                            var longitud={{$formulario->puntoReferencia->longitud}};
                            infowindow.open(map, marker_{{$estacion->id}}); 
    
                            directionsRenderer{{$estacion->id}}.setMap(map);
                            // des aki para ver 
                            directionsService{{$estacion->id}}.route({
                            origin: {lat: latitu, lng: longi},  // Haight.
                            destination: {lat: latitud, lng:longitud},  // Ocean Beach.
                            // Note that Javascript allows us to access the constant
                            // using square brackets and a string value as its
                            // "property."
                            
                            travelMode: 'DRIVING',
                            }, function(response, status) {
                            if (status == 'OK') {
                                directionsRenderer{{$estacion->id}}.setDirections(response);
                            } else {
                                window.alert('Directions request failed due to ' + status);
                            }
                            });
                          
                        @endif
                    @endforeach
                @endif         
            }
        @endif
    
    
            
    </script>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0Ko6qUa0EFuDWr77BpNJOdxD-QLstjBk&callback=initMap">
      </script>
      <style type="text/css">
          #map {
              height: 60%;
              width: 100%;
          }
          #nuevaTabla {
            border-collapse: collapse;
            width: 100%;
            }

            #nuevaTabla, th, td {
            border: 1px solid black;
            }
            .noBorder{
                border: none; 
            }
            p{
                font-size: 12px;  
            }
      </style>