@extends('layouts.app',['title'=>'Actualizar vehículo'])

@section('breadcrumbs', Breadcrumbs::render('editarTipoVehiculo',$tipoVehiculo)) 

@section('content')

<form action="{{ route('actualizarTipoVehiculo') }}" method="POST" id="formGuardar">

    <div class="card">
        <div class="card-header">
            Complete información
        </div>
        <div class="card-body">
            @csrf

            <input type="hidden" name="tipo" value="{{ $tipoVehiculo->id }}" required>
            
            <div class="form-group row">
                <label for="nombre" id="nombre" class="col-md-4 col-form-label text-md-right">Nombre del tipo de vehículo<i class="text-danger">*</i></label>
                <div class="col-md-6">
                        <input type="text" name="nombre" value="{{ old('nombre',$tipoVehiculo->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>

                    @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="codigo" id="codigo" class="col-md-4 col-form-label text-md-right">Código del tipo de vehículo<i class="text-danger">*</i></label>
                <div class="col-md-6">
                    <input type="text" name="codigo" value="{{ old('codigo',$tipoVehiculo->codigo) }}" class="form-control @error('codigo') is-invalid @enderror" placeholder="Ingrese código.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                    @error('codigo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <button class="btn btn-dark" type="submit">Guardar cambios</button>
        </div>
    </div>
</form>


@push('linksCabeza')
{{--  validate  --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>

        $('#menuVehiculos').addClass('active');

        $( "#formGuardar" ).validate({
            rules: {
                nombre: {
                    required: true,
                    maxlength: 191
                }
            },
        });

       
        
    </script>
    
@endprepend
@endsection
