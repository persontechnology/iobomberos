@extends('layouts.app',['title'=>'Generar asistencia'])
@section('breadcrumbs', Breadcrumbs::render('generarAsistencia'))
@section('content')


@if (count($estaciones))
    
        <div class="container">
            <div class="row">
                @foreach ($estaciones as $est)
                @can('generarAsistencia', $est)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-img-actions">
                            <a href="{{ route('listadoPersonalAsistencia',$est->id) }}" data-popup="lightbox">
                                

                                @if (Storage::exists($est->foto))
                                    <img class="card-img-top img-fluid" src="{{ Storage::url($est->foto) }}" alt="">
                                @else
                                <img src="{{ asset('img/estacion.png') }}" alt="" class=" card-img-top img-fluid">
                                @endif

                                <span class="card-img-actions-overlay card-img-top">
                                    <i class="fas fa-plus fa-5x"></i>
                                </span>
                            </a>
                        </div>

                        <div class="card-body bg-dark">
                            <h2 class="card-title text-center">
                                <strong>{{ $est->nombre }}</strong>
                            </h2>
                            <p class="card-text">
                                {{ $est->direccion }}
                            </p>
                        </div>
                    </div>
                </div>
                @endcan
                @endforeach
            </div>
        </div>
    
@else
    <div class="alert alert-primary" role="alert">
        <strong>NO existe estaciiones</strong>
    </div>
@endif

@prepend('linksPie')
    <script>
        
        $('#menuGenerarAsistencia').addClass('active');
        
    </script>
    
@endprepend
@endsection
