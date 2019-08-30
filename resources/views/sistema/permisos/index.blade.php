@extends('layouts.app',['title'=>'Permisos'])

@section('breadcrumbs', Breadcrumbs::render('permisos',$rol))



@section('content')

<form action="{{ route('sincronizarPermiso') }}" method="post">
    @csrf
    <input type="hidden" name="rol" value="{{ $rol->id }}" required>
    <div class="card">
        <div class="card-header">
            Permisos en rol {{ $rol->name }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Asignar</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach ($permisos as $per)
                        <tr>
                            <th scope="row">{{ $per->name }}</th>
                            <td>
                                <input name="permisos[]" value="{{ $per->id }}" type="checkbox" {{ $rol->hasPermissionTo($per) ?'checked':'' }}  data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger" data-size="xs">
                            </td>
                        </tr>
    
                        @endforeach
    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted">
            <button class="btn btn-dark">Actualizar roles</button>
        </div>
    </div>
</form>

@push('linksCabeza')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>

@endpush

@prepend('linksPie')
    <script>
        $('#menuRoles').addClass('active');
    </script>

    
@endprepend

@endsection
