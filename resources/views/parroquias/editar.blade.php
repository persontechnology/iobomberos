@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('editarParroquia',$parroquia))


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Complete información</div>

                <div class="card-body">
                    <form action="{{ route('actualizarParroquia') }}" method="POST" id="formGuardar">
                        @csrf
                        <input type="hidden" name="parroquia" value="{{ $parroquia->id }}" required>
                        <label for="nombre">Nombre de la parroquia</label>
                        <div class="input-group mb-12">
                            <input type="text" name="nombre" value="{{ old('nombre',$parroquia->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                            
                        </div>
                        <label for="nombre">Código de la parroquia</label>
                        <div class="input-group mb-12">
                            <input type="text" name="codigo" value="{{ old('codigo',$parroquia->codigo) }}" class="form-control @error('codigo') is-invalid @enderror" placeholder="Ingrese codigo.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                            
                        </div>
                        <div class="input-group-append mt-2">
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
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuParroquias').addClass('active');

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
