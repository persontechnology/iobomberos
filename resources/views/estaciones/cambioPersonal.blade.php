@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    @foreach ($estaciones as $est)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-dark">
                    <h1>{{ $est->nombre }}  {{ $est->id }}</h1>
                </div>
                <div class="card-body list-group col milista" id="estacion{{ $est->id }}">
                        
                    @foreach ($usuarios as $user)
                        
                        @if ($user->estacion->id==$est->id)
                        <div class="list-group-item" id="{{ $user->id }}">
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start bg-secondary">
                                    <img src="https://cdn1.iconfinder.com/data/icons/flat-character-color-1/60/flat-design-character_6-512.png" class="img-fluid" width="25px" alt="">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $user->name }} {{ $user->id }}</h5>
                                    <small>{{ $user->email }}</small>
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
                        </div>
                        @endif
                        
                    @endforeach

                       
                </div>
            </div>
        </div>

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

@push('linksCabeza')

<script src="{{ asset('admin/plus/sortable/Sortable.min.js') }}"></script>


@endpush



@prepend('linksPie')
    <script>
        
        $('#menuEscritorio').addClass('active');
       
       
    </script>
    
@endprepend
@endsection
