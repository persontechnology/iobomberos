@extends('layouts.app',['title'=>'Roles'])

@section('breadcrumbs', Breadcrumbs::render('roles'))



@section('content')
<form action="{{ route('guardarRol') }}" method="post">
    @csrf
    <div class="input-group mb-1">
        <input type="text" name="rol" value="{{ old('rol') }}" class="form-control" placeholder="Ingrese nuevo rol.." aria-label="Ingrese nuevo rol.." aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-dark" type="submit">Guardar</button>
        </div>
    </div>
</form>

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
        $('#menuRoles').addClass('active');

        function eliminar(arg){
            var url="{{ route('eliminarRol') }}";
            var id=$(arg).data('id');
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar este rol!",
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
                $.post( url, { id: id })
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
    {!! $dataTable->scripts() !!}
    
@endprepend

@endsection
