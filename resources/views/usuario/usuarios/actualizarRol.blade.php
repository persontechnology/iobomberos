@extends('layouts.app',['title'=>'Actualizar roles de usuario'])

@section('breadcrumbs', Breadcrumbs::render('editarRolUsuario',$usuario))



@section('content')
<form method="POST" action="{{ route('actualizarRolUsuario') }}">
    @csrf
    <input type="hidden" name="usuario" value="{{ $usuario->id }}" required>
    <div class="card">
        <div class="card-header">
            Actualizar roles de {{ $usuario->name }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Rol</th>
                        <th scope="col">Asignar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <th scope="row">{{ $rol->name }}</th>
                                <td>
                                    <input class="opcionPermisos" name="roles[{{ $rol->id }}]" {{ $usuario->hasRole($rol)?'checked':'' }} value="{{ $rol->id }}" type="checkbox"   data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" data-size="xs">
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted">
                <button type="submit" class="btn btn-dark">
                    {{ __('Actualizar roles') }}
                </button>
        </div>
    </div>
</form>


@push('linksCabeza')

<link href="{{ asset('admin/plus/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/plus/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuUsuarios').addClass('active');
    </script>
    
@endprepend

@endsection
