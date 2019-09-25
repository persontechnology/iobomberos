<div class="container ">
        <div class="row">
        @foreach ($estaciones as $est)
        {{-- Inicio de contenido para lista  de personal --}}
            <div class="col-md-4 ">
                <div class="card ">
                    <div class="card-header bg-dark header-elements-inline">
                        <h5>{{ $est->nombre }}  {{ $est->id }}</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a> 
                                <a class="list-icons-item" data-action=""></a>                  		
                            </div>
                        </div>
                    </div>
                    {{-- crear la lista para ver registros por estacion --}}
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="form-group-feedback form-group-feedback-left">
                                <input type="text" id="buscar_{{ $est->id }}" class="form-control form-control-lg" placeholder="Buscar Registro">
                                <div class="form-control-feedback form-control-feedback-lg">
                                    <i class="icon-search4 text-muted"></i>
                                </div>
                            </div>                              
                        </div>
                       <ul class="media-list milista estacion1_{{ $est->id }}" id="estacion{{ $est->id }}">
                        @foreach ($usuarios as $user)
                            
                            @if ($user->estacion->id==$est->id)
                            <li class= "media repuesta1_{{ $est->id }}" id="{{ $user->id }}">
    
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start bg-secondary">
                                    
                                    <div class="d-flex w-100  ">
                                        @if (Storage::exists($user->foto))
                                            <img src="{{ Storage::url($user->foto) }}" alt="" class="img-fluid" width="35px;">
                                        @else
                                            <img src="{{ asset('img/user.png') }}" alt="" class="img-fluid" width="35px;">
                                        @endif
                                        <small class="mb-1">{{ $user->name }}</small>
                                        
                                    </div>
                                    <p class="mb-1">
                                        {{ $user->telefono }}
                                    </p>
                                    <small>
                                        @foreach ($user->getRoleNames() as $rol)
                                            {{ $rol }},
                                        @endforeach
                                    </small>
                                </a>
                            </li>
                            @endif
                            
                        @endforeach
                       </ul>
                           
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
                    console.log(texto);    
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
                            var user=evt.item.id;
                            var estacion=evt.to.id.split('estacion')[1];
                            
                            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
                            $.post("{{ route('actualizarPersonalEstacion') }}", { estacion: estacion,user:user })
                            .done(function( data ) {
                                if(data.success){
                                    cargaListadoss();
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