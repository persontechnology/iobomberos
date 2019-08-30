@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Bienvenido <strong>{{ Auth::user()->email }}</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <img src="{{ asset('admin/img/home.jpg') }}" class="img-fluid img-thumbnail rounded mx-auto d-block" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

@prepend('linksPie')
    <script>
        
        $('#menuEscritorio').addClass('active');
        
    </script>
    
@endprepend
@endsection
