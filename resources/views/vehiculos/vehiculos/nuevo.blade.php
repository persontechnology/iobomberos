@extends('layouts.app',['title'=>'Nuevo vehiculo'])

@section('breadcrumbs', Breadcrumbs::render('nuevoVehiculos',$tipo))
@section('content')
<form method="POST" action="{{ route('guardarVehiculo') }}" id="formNuevoUsuario">
    @csrf
    <div class="card">
        <div class="card-header">
            Complete información
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" value="{{$tipo->id}}" name="tipo" id="tipo">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Estaciones<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                @if($estaciones)
                                <select class="form-control @error('estacion') is-invalid @enderror" name="estacion" id="estacion" >
                                    @foreach($estaciones as $esta)
                                    <option value="{{ $esta->id }}" {{ (old("estacion") == $esta->id ? "selected":"") }} >{{$esta->nombre}}</option>
                                    @endforeach
                                </select>
        
                                @error('estacion_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label for="placa" class="col-md-4 col-form-label text-md-right">{{ __('Placa') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="placa" type="text" class="form-control @error('placa') is-invalid @enderror" name="placa" value="{{ old('placa') }}" required autocomplete="placa" autofocus placeholder="Placa">
        
                                @error('placa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="codigo" class="col-md-4 col-form-label text-md-right">Código<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="codigo" type="number" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}" required autocomplete="codigo" autofocus placeholder="Código">
        
                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                          <div class="form-group row">
                            <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ old('marca') }}" required autocomplete="marca" autofocus placeholder="Marca">
        
                                @error('marca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ old('modelo') }}" required autocomplete="modelo" autofocus placeholder="Modelo">
        
                                @error('modelo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">

                        <div class="form-group row">
                            <label for="cilindraje" class="col-md-4 col-form-label text-md-right">Cilindraje<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="cilindraje" type="text" class="form-control @error('cilindraje') is-invalid @enderror" name="cilindraje" value="{{old('cilindraje')}}" placeholder="Cilindraje" required>
        
                                @error('cilindraje')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="anio" class="col-md-4 col-form-label text-md-right">Año<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="anio" type="number" class="form-control @error('anio') is-invalid @enderror" name="anio" value="{{old('anio')}}" placeholder="Año" required>
        
                                @error('anio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="motor" class="col-md-4 col-form-label text-md-right">Motor<i class="text-danger">*</i></label>
        
                            <div class="col-md-6">
                                <input id="motor" type="text" class="form-control @error('motor') is-invalid @enderror" name="motor" value="{{old('motor')}}" placeholder="Motor" required>
        
                                @error('motor')
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
        $('#menuVehiculos').addClass('active');
        
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
