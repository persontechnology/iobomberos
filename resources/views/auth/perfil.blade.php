@extends('layouts.app',['title'=>'Mi perfil'])

@section('breadcrumbs', Breadcrumbs::render('miPerfil'))

@section('content')
<form action="{{ route('actualizarMiPerfil') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        
        <div class="card-header header-elements-inline">
            <h6 class="card-title">
                {{ $usuario->name }}
            </h6>
            <div class="header-elements">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        @if (Storage::exists($usuario->foto))
                            <a href="{{ Storage::url($usuario->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
                                <img src="{{ Storage::url($usuario->foto) }}" alt="" class="rounded-circle" width="32" height="32">
                            </a>
                        @else
                            <img src="{{ asset('admin/img/cactu.jpg') }}" class="rounded-circle" width="32" height="32" alt="">
                        @endif	
                        
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body">
                
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
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<i class="text-danger">*</i></label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$usuario->email) }}" required autocomplete="email" readonly>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
                <label for="exampleFormControlFile1" class="col-md-4 col-form-label text-md-right">Foto de perfil</label>
                <div class="col-md-6">
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="foto" accept="image/*">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-4 col-form-label text-md-right">Mis roles</label>
                <div class="col-md-6">
                    @foreach ($usuario->getRoleNames() as $rol)
                    {{ $rol }},
                    @endforeach
                </div>
            </div>
            
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Guardar cambios</button>
        </div>
    </div>
</form>
@push('linksCabeza')

@endpush

@prepend('linksPie')
    <script>
        $('#menuEscritorio').addClass('active');
    </script>
@endprepend

@endsection
