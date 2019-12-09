@extends('layouts.app',['title'=>'Nuevo Registro Pre-Hospitalaria '])
@section('breadcrumbs', Breadcrumbs::render('formularios'))
@section('content')
<!-- My messages -->
<div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Mis formularios</h6>
            
        </div>

        <!-- Numbers -->
        <div class="card-body py-0">
            <div class="row text-center">
                <div class="col-6">
                    <div class="mb-3">
                        <h5 class="font-weight-semibold mb-0">{{$formulariosAsignados->count()}}</h5>
                        <span class="text-muted font-size-sm">Por Completar</span>
                    </div>
                </div>              

                <div class="col-6">
                    <div class="mb-3">
                        <h5 class="font-weight-semibold mb-0">{{ $formulariosFinalizados->count()}}</h5>
                        <span class="text-muted font-size-sm">Finalizados</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /numbers -->


        <!-- Area chart -->
        <div id="messages-stats"></div>
        <!-- /area chart -->


        <!-- Tabs -->
        <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-indigo-400 border-x-0 border-bottom-0 border-top-indigo-300 mb-0">
            <li class="nav-item">
                <a href="#messages-tue" class="nav-link font-size-sm text-uppercase active" data-toggle="tab">
                    Por Completar
                </a>
            </li>

            <li class="nav-item">
                <a href="#messages-mon" class="nav-link font-size-sm text-uppercase" data-toggle="tab">
                    Finalizados
                </a>
            </li>
        </ul>
        <!-- /tabs -->


        <!-- Tabs content -->
        <div class="tab-content card-body">
            <div class="tab-pane active fade show" id="messages-tue">
                <ul class="media-list">
                    @if($formulariosAsignados->count()>0)
                    @foreach ($formulariosAsignados as $asignados)
                    <li class="media">
                        <div class="mr-3 position-relative">
                            <img src="{{asset('img/user.png') }}" class="rounded-circle" width="36" height="36" alt="">
                            <span class="badge bg-danger-400 badge-pill badge-float border-2 border-white">{{ $asignados->numero}}</span>
                        </div>

                        <div class="media-body">
                            <div class="d-flex justify-content-between">
                                
                                <a href="#">Completar formulario N° <strong>{{ $asignados->numero}}</strong></a>
                                <span class="font-size-sm text-muted">Fecha: {{$asignados->fecha}}</span>
                                <span class="font-size-sm text-muted">Punto Referencia: {{$asignados->fecha}}</span>
                                <span class="font-size-sm text-muted">14:58</span>

                            </div>

                            Emergencia: {{$asignados->emergencia->nombre}}
                        </div>
                    </li>                      
                        
                    @endforeach
                    @else
                        <div class="alert alert-danger" role="alert">
                            No tiene formularios para completar
                        </div>
                    @endif
                </ul>
            </div>

            <div class="tab-pane fade" id="messages-mon">
                <ul class="media-list">
                    @if ($formulariosFinalizados->count()>0)
                    <li class="media">
                        <div class="mr-3">
                            <img src="../../../../global_assets/images/demo/users/face2.jpg" class="rounded-circle" width="36" height="36" alt="">
                        </div>

                        <div class="media-body">
                            <div class="d-flex justify-content-between">
                                <a href="#">Isak Temes</a>
                                <span class="font-size-sm text-muted">Tue, 19:58</span>
                            </div>

                            Reasonable palpably rankly expressly grimy...
                        </div>
                    </li>                   
                        
                    @else
                    <div class="alert alert-danger" role="alert">
                            No tiene formularios Finalizados
                        </div>
                    @endif
                </ul>
            </div>

        </div>
        <!-- /tabs content -->

    </div>
    <!-- /my messages -->
    @push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plus/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('admin/plus/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@prepend('linksPie')
<script type="text/javascript">
  
     $('#menuMisFormularios').addClass('active');
     $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

@endprepend
@endsection