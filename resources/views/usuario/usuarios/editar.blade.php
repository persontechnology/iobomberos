@extends('layouts.app',['title'=>'Actualizar Personal operativo'])

@section('breadcrumbs', Breadcrumbs::render('editarUsuario',$usuario))


@section('content')
<form method="POST" action="{{ route('actualizarUsuario') }}" id="actualizarForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="usuario" value="{{ $usuario->id }}" required>
    <div class="card">
        <div class="card-header">
            Complete información
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Estaciones<i class="text-danger">*</i></label>

                <div class="col-md-6">
                    @if($estaciones)
                    <select class="form-control @error('estacion_id') is-invalid @enderror" name="estacion_id" id="estacion_id" >
                        @foreach($estaciones as $esta)
                        <option value="{{ $esta->id }}" {{ (old("estacion_id",$usuario->estacion_id)==$esta->id? "selected":"") }} >{{$esta->nombre}}</option>
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
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}<i class="text-danger">*</i></label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$usuario->name) }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="telefono" class="col-md-4 col-form-label text-md-right">Teléfono/Celular<i class="text-danger">*</i></label>

                <div class="col-md-6">
                    <input id="telefono" type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{old('telefono',$usuario->telefono)}}"  autocomplete="telefono" placeholder="Teléfono">

                    @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<i class="text-danger">*</i></label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$usuario->email) }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="estado">Estado<i class="text-danger">*</i></label>
                 <div class="col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input {{ $errors->has('estado') ? ' is-invalid' : '' }}" value="Activo" id="Activo" name="estado"  required {{ old('estado',$usuario->estado)=='Activo'?'checked':'checked' }}>
                        <label class="custom-control-label" for="Activo">Activo</label>
                    </div>



                    <div class="custom-control custom-radio ml-1">
                        <input type="radio" class="custom-control-input{{ $errors->has('estado') ? ' is-invalid' : '' }}" value="Dado de baja" id="Dado de baja" name="estado" required {{ old('estado',$usuario->estado)=='Dado de baja'?'checked':'' }}>
                        <label class="custom-control-label" for="Dado de baja">Dado de baja</label>

                          @if ($errors->has('estado'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('estado') }}</strong>
                            </span>
                          @endif
                      </div>
                  </div>
              </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Foto de perfil') }}</label>

                <div class="col-md-6">
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="foto" accept="image/*">
                    @if (Storage::exists($usuario->foto))
                        <a href="{{ Storage::url($usuario->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
                            <img src="{{ Storage::url($usuario->foto) }}" alt="" class="img-fluid mt-2">
                        </a>
                    @endif
                </div>
                {{ $usuario->foto }}
            </div>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Guardar cambios</button>
        </div>
    </div>
</form>


@push('linksCabeza')
{{-- validtae --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>
@endpush

@prepend('linksPie')
    <script>
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuUsuarios').addClass('active');
        $('#actualizarForm').validate({
            rules: {
                name:{
                    required:true,
                },
                password: {
                    required: false,
                    minlength: 8
                },
                password_confirmation: {
                    required: false,
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
