@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Complete información</div>

                <div class="card-body">
                        <form action="{{ route('actualizarTipoEmergencia') }}" method="POST" id="formGuardar">
                            @csrf
                            <input type="hidden" name="teme" value="{{ $tipoEmergencia->id }}" required>
                            <label for="nombre">Nombre de emergencia</label>
                            <div class="input-group mb-3">
                                <input type="text" name="nombre" value="{{ old('nombre',$tipoEmergencia->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                
                                <div class="input-group-append">
                                    <button class="btn btn-dark" type="submit">Guardar cambios</button>
                                </div>
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
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuEmergencia').addClass('active');

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
