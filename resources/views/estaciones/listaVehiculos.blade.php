<div class="container ">
        <div class="row">
            @foreach ($estaciones as $est)
            {{-- Inicio de contenido para lista  de personal --}}
                <div class="col-md-4 ">
                    <div class="card ">
                        <div class="card-header bg-dark header-elements-inline">
                            <h5>{{ $est->nombre }}  {{ $est->id }}</h5>
                            
                        </div>
                        {{-- crear la lista para ver registros por estacion --}}
                        <div class="card-body ">
                            <div class="input-group mb-3">
                                <div class="form-group-feedback form-group-feedback-left">
                                    <input type="text" id="buscar_{{ $est->id }}" class=" stiloitems form-control form-control-lg" placeholder="Buscar Registro">
                                    <div class="form-control-feedback form-control-feedback-lg">
                                        <i class="icon-search4 text-muted"></i>
                                    </div>
                                </div>                              
                            </div>
                            <div class="list-cards   ">
                                <ul class="media-list ista  estacion1_{{ $est->id }}" id="estacion{{ $est->id }}">
                                    @foreach ($vehiculos as $vehiculo)                                    
                                        @if ($vehiculo->estacion->id==$est->id)
                                        <li class= " stiloitems media repuesta1_{{ $est->id }}" id="{{ $vehiculo->id }}">            
                                            <a href="#" class=" stiloitems1 list-group-item list-group-item-action flex-column align-items-start ">
                                                
                                                <div class="d-flex w-100  ">
                                                    @if (Storage::exists($vehiculo->foto))                                            
                                                        <img src="{{ Storage::url($vehiculo->foto) }}" alt="" class="rounded-circle"  width="45px;">
                                                
                                                    @else
                                                        <img src="{{ asset('img/carroBomberos.png') }}" alt="" class="rounded-circle" width="45px;">
                                                    @endif
                                                    <small class="mb-1">{{ $vehiculo->tipoVehiculo->nombre.' '. $vehiculo->marca.' '. $vehiculo->modelo  }}</small>
                                                    
                                                </div>
                                                <p class="mb-1">
                                                    {{$vehiculo->tipoVehiculo->codigo.''.$vehiculo->codigo }}
                                                </p>
                                                <small>
                                                        {{ $vehiculo->anio.' '. $vehiculo->placa }}
                                                </small>
                                            </a>
                                        </li>
                                        @endif
                                        
                                    @endforeach
                                </ul>
                            </div>  
                        </div>                    
                        {{-- Fin lista de registros --}}
                    </div>
                </div>
                <script>
                
                    $('#buscar_{{ $est->id }}').keyup(function(ev){   
                        var texto = $(this).val();            
                        var numero=$(this).attr('id').split('_')           
                        filtro(texto,numero[1]);
                    });
                
                    function filtro(texto,numero) {                  
                        var lista = $(".estacion1_"+numero+" > .repuesta1_"+numero+"").hide()
                        .filter(function(){
                            var item = $(this).text();
                            var padrao = new RegExp(texto, "i");
                        
                            return padrao.test(item);
                        }).closest(".estacion1_"+numero+" > .repuesta1_"+numero+"").show();
                            
                    }
                </script>
        
                <script>
                        new Sortable(estacion{{ $est->id }}, {
                            group: 'shared',
                            animation: 150,
                            onChange: function(evt) {
                                var vehiculo=evt.item.id;
                                var estacion=evt.to.id.split('estacion')[1];
                                
                                $.blockUI({message:'<h1>Espere por favor.!</h1>'});
                                $.post("{{ route('actualizarVehiculoEstacion') }}", { estacion: estacion,vehiculo:vehiculo })
                                .done(function( data ) {
                                    if(data.success){
                                        cargaListadosVehiculo();
                                        notificar("success",data.success);                                        
                                    }
                                    if(data.default){
                                        notificar("default",data.default);   
                                    }
                                }).always(function(){
                                    $.unblockUI();
                                }).fail(function(){
                                    notificar("error","Ocurrio un error");
                                });
        
        
                            }
                        });
                </script>
               
             
            @endforeach
        
            </div>
        </div>
<style>
    .list-cards {
        overflow: auto;
        max-height: 350px;
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