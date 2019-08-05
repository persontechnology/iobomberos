@extends('layouts.app',['Confirmar Email'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-4">
                <img src="{{ asset('admin/img/bomberos.png') }}" alt="" class="img-responsive img-fluid d-none d-sm-block">
            </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>

@push('linksCabeza')
    <script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
@endpush

@prepend('linksPie')
 
@endprepend


@endsection
