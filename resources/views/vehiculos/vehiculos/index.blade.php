@extends('layouts.app',['title'=>'Vehículos'])

@section('breadcrumbs', Breadcrumbs::render('vehiculos',$tipo)) 

@section('barraLateral')

    <div class="breadcrumb justify-content-center">
        <a href="{{route('nuevoVehiculo',$tipo->id)}}" class="breadcrumb-elements-item">
            <i class="fas fa-plus"></i>
            Nuevo vehículo
        </a>     
    </div>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            Vehículos de tipo <span class="badge badge-flat border-success text-success-600"> {{ $tipo->nombre.'-'.$tipo->codigo  }} </span>
        </h4>
    </div>
    <div class="card-body">
            <div class="table-responsive">
                {!! $dataTable->table()  !!}
            </div>
    </div>

</div>



@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plus/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('admin/plus/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{{--  validate  --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>


@endpush

@prepend('linksPie')
    <script>

        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuVehiculos').addClass('active');
        $( "#formGuardar" ).validate({
            rules: {
                nombre: {
                    required: true,
                    maxlength: 191
                }
            },
        });

        function eliminar(arg){
        
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar esta emergencia !",
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
                $.post( "{{ route('eliminarVehiculo') }}", { vehiculo: $(arg).data('id') })
                .done(function( data ) {
                    if(data.success){
                        $('#dataTableBuilder').DataTable().draw(false);
                        notificar("info",data.success);
                    }
                    if(data.default){
                        notificar("default",data.default);   
                    }
                    console.log(data)
                }).always(function(){
                    $.unblockUI();
                }).fail(function(){
                    notificar("error","Ocurrio un error");
                });
    
            });
        }

        
    </script>
    {!! $dataTable->scripts() !!}
    
@endprepend

@endsection
