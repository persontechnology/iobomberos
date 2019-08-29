@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('editarTipoVehiculo',$tipoVehiculo)) 

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Complete información</div>

                <div class="card-body">
                        <form action="{{ route('actualizarTipoVehiculo') }}" method="POST" id="formGuardar">
                            @csrf
                            <input type="hidden" name="tipo" value="{{ $tipoVehiculo->id }}" required>
                            <label for="nombre">Nombre del tipo de vehículo</label>
                            <div class="input-group mb-3">
                                <input type="text" name="nombre" value="{{ old('nombre',$tipoVehiculo->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                
                            </div>
                             <label for="codigo">Codigo del tipo de vehículo</label>
                            <div class="input-group mb-3">
                                <input type="text" name="codigo" value="{{ old('codigo',$tipoVehiculo->codigo) }}" class="form-control @error('codigo') is-invalid @enderror" placeholder="Ingrese codigo.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="submit">Guardar cambios</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>



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
