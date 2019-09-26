@extends('layouts.app',['title'=>'Estaciones'])
@section('breadcrumbs', Breadcrumbs::render('estaciones'))
@section('barraLateral')

    <div class="breadcrumb justify-content-center">
        <a href="{{ route('nuevaEstacion') }}" class="breadcrumb-elements-item">
            <i class="fas fa-plus"></i> Nueva estación
        </a>
       
        <div class="breadcrumb-elements-item dropdown p-0">
            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="icon-gear mr-2"></i>
                Cambio de recursos
            </a>

            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 40px, 0px);">
                <a href="{{ route('cambioPersonal') }}" class="dropdown-item">
                        <i class="fas fa-user-clock"></i> Cambio de personal
                    </a>
                <a href="{{ route('cambioVehiculo') }}" class="dropdown-item">
                    <i class="fas fa-car"></i> Cambio de Vehículos </a>
                
            </div>
        </div>
        
    </div>
@endsection
@section('content')


<div class="card card-body">

    <div class="table-responsive">
        {!! $dataTable->table()  !!}
    </div>
</div>

@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plus/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('admin/plus/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@prepend('linksPie')
  <script type="text/javascript">
       $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuEstacion').addClass('active');
  </script>
    {!! $dataTable->scripts() !!}
    <script type="text/javascript">
        
        function eliminar(arg){
            var url="{{ route('eliminarEstacion') }}";
            var id=$(arg).data('id');
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar la estación.!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-dark",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "¡Sí, bórralo!",
                cancelButtonText:"Cancelar",
                closeOnConfirm: false
            },
            function(){
                swal.close();
                $.blockUI({message:'<h1>Espere por favor.!</h1>'});
                $.post( url, { estacion: id })
                .done(function( data ) {
                    if(data.success){
                        $('#dataTableBuilder').DataTable().draw(false);
                        notificar("info",data.success);
                    }
                    if(data.default){
                        notificar("default",data.default);   
                    }
                }).always(function(){
                    $.unblockUI();
                }).fail(function(){
                    notificar("error","Ocurrio un error");
                });
    
            });
        }
    </script>
    
@endprepend

@endsection
