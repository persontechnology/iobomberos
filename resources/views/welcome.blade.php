@extends('layouts.app',['title'=>'Bienvenido'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">

                <div class="card-header text-center">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('img/slider/1.png')}}" alt="First slide">
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('img/slider/2.jpg') }}" alt="Second slide">
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('img/slider/3.jpg') }}" alt="Third slide">
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                    </div>
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
