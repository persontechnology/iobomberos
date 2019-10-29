@if (count($estacionesNo)>0)
<div class="card">
    <div class="card-header">
        Agreagas estaciones
    </div>
    <div class="card-body">
        @foreach ($estacionesNo as $estacionNo)
            {{ $estacionNo->nombre }}
        @endforeach
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
            @if (count($estacionesSi)>0)
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    @php($esi=0)
                    @foreach ($estacionesSi as $estacionSi)
                    @php($esi++)
                        <li class="nav-item">
                            <a class="nav-link {{ $esi==1?'active':'' }}" id="{{ $estacionSi->id }}-tab" data-toggle="tab" href="#estacion_{{ $estacionSi->id }}" role="tab" aria-controls="{{ $estacionSi->id }}" aria-selected="{{ $esi==1?'active':'false' }}">
                                {{ $estacionSi->nombre }}
                            </a>
                        </li>
                    @endforeach
                    
                </ul>
                <div class="tab-content" id="myTabContent">
                    @php($esiCont=0)
                    @foreach ($estacionesSi as $estacionSiCont)
                    @php($esiCont++)
                    <div class="tab-pane fade {{ $esiCont==1?'show active':'' }}" id="estacion_{{ $estacionSiCont->id }}" role="tabpanel" aria-labelledby="{{ $estacionSiCont->id }}-tab">
                        

                        @if (count($estacionSiCont->vehiculosDisponibles)>0)
                        <div class="row">
                            @foreach ($estacionSiCont->vehiculosDisponibles as $vehiculo)
                            <div class="col-xl-2 col-md-6">
                                <div class="card card-body">
                                    <div class="media">
                                        <div class="mr-3">
                                            @if (Storage::exists($vehiculo->foto))
                                                <img src="{{ Storage::url($vehiculo->foto) }}" class="rounded" width="38" height="38" alt="">
                                            @else
                                                <img src="{{ asset('img/carroBomberos.png') }}" class="rounded" width="38" height="38" alt="">
                                            @endif
                                        </div>
        
                                        <div class="media-body">
                                            <div class="font-weight-semibold">
                                                {{ $vehiculo->tipoVehiculo->codigo.''.$vehiculo->codigo }}
                                            </div>
                                        </div>
        
                                        <div class="ml-3 align-self-center">
                                            <span class="badge badge-mark bg-success border-success"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else    
                        <div class="alert alert-warning" role="alert">
                            <strong>Está estación no tiene vehículos diponibles</strong>
                        </div>
                        @endif
                        


                    </div>  
                    @endforeach
                    
                    
                </div>    
            @else
                <div class="alert alert-warning" role="alert">
                    <strong>Formulario sin asignar estaciones</strong>
                </div>
            @endif
    </div>
   
</div>


