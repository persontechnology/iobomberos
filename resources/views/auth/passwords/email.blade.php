@extends('layouts.app',['title'=>'Restablecer contraseña'])

@section('breadcrumbs', Breadcrumbs::render('resetPassword'))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                <img src="{{ asset('admin/img/bomberos.png') }}" alt="" class="img-responsive img-fluid d-none d-sm-block">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('linksCabeza')

    <script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>
@endpush

@prepend('linksPie')
    <script> 
        $( "#resetForm" ).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
        });
        $('#menuLogin').addClass('active');
        
    </script>
@endprepend
@endsection
