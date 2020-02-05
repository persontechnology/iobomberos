@extends('layouts.app',['title'=>'Personal operativo'])

@section('breadcrumbs', Breadcrumbs::render('usuarios'))

@section('barraLateral')

    <div class="breadcrumb justify-content-center">
            <a href="{{ route('usuariosNuevo') }}" class="breadcrumb-elements-item">
                <i class="fas fa-plus"></i>
                Nuevo personal Op.
            </a>
            <a href="{{ route('usuariosImportar') }}" class="breadcrumb-elements-item">
                <i class="fas fa-file-excel"></i>
                Importar personal Op.
            </a>
        <div class="breadcrumb-elements-item dropdown p-0">
            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-users"></i>
                Ver personal Op. por roles
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('usuarios') }}" class="dropdown-item"><i class="fas fa-user-lock"></i>Ver todos</a>
                @foreach ($roles as $rol)
                    <a href="{{ route('usuariosPoRol',$rol->name) }}" class="dropdown-item"><i class="fas fa-user-lock"></i>{{ $rol->name }}</a>
                @endforeach
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
    <script>
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuUsuarios').addClass('active');

        function eliminar(arg){
            var url="{{ route('eliminarUsuario') }}";
            var id=$(arg).data('id');
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar al personal operativo.!",
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
                $.post( url, { user: id })
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
