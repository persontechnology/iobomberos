@extends('layouts.app',['title'=>'Información de usuario'])

@section('breadcrumbs', Breadcrumbs::render('informacionUsuario',$usuario))

@section('barraLateral')

    <div class="breadcrumb justify-content-center">
        <div class="breadcrumb-elements-item dropdown p-0">
            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-users"></i>
                Más opciones
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('usuarioInformacionPdf',$usuario->id) }}" class="dropdown-item"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
                <a href="{{route('usuarioInformacionImprimir',$usuario->id)}}" class="dropdown-item"><i class="fas fa-print"></i> Imprimir</a>
            </div>
        </div>
    </div>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        Información de usuario
    </div>
    <div class="card-body">
        {{-- carga de datos de usuario --}}
        @include('usuario.usuarios.datos')
    </div>
    <div class="card-footer text-muted">
    </div>
</div>



@push('linksCabeza')

@endpush

@prepend('linksPie')
    <script>
        $('#menuUsuarios').addClass('active');
    </script>
    
@endprepend

@endsection
