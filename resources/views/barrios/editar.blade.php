@extends('layouts.app',['title'=>'Nuevo barrio'])

@section('breadcrumbs', Breadcrumbs::render('editarBarrio',$barrio))

@section('content')
<form method="POST" action="{{ route('actualizarBarrio') }}" id="formNuevoUsuario" >
    @csrf
    <div class="card">
        <div class="card-header">
            Complete información
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                            <input type="hidden" name="barrio" value="{{ $barrio->id }}" required>
                       
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Parroquias<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                @if($parroquias)
                                <select class="form-control @error('parroquia') is-invalid @enderror" name="parroquia" id="parroquia" >
                                    @foreach($parroquias as $esta)
                                    <option value="{{ $esta->id }}" {{ (old("parroquia",$barrio->parroquia_id)==$esta->id? "selected":"") }}  >{{$esta->nombre .' - '. $esta->codigo }}</option>
                                    @endforeach
                                </select>
        
                                @error('parroquia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del barrio') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre',$barrio->nombre) }}" required autocomplete="nombre" autofocus placeholder="Nombre">
        
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">Código<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{old('codigo',$barrio->codigo)}}" placeholder="Teléfono">
        
                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>       
                        
                    </div>
                </div>
        </div>
        <div class="card-footer text-muted">
                <button type="submit" class="btn btn-dark">
                    {{ __('Guardar') }}
                </button>
        </div>
    </div>
</form>


@push('linksCabeza')
{{-- toogle --}}
<link href="{{ asset('admin/plus/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/plus/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
{{-- validtae --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuUsuarios').addClass('active');

        
        $( "#formNuevoUsuario" ).validate({
            rules: {
                name:{
                    required:true,
                },
                telefono:{
                    required:true,
                    minlength: 6,
                    maxlength: 10,
                    number:true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                }
            },
        }); 
    </script>
    
@endprepend

@endsection
