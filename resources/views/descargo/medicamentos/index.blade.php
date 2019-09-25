@extends('layouts.app',['title'=>'Medicamentos'])
@section('breadcrumbs', Breadcrumbs::render('medicamentos',$insumo))
@section('barraLateral')

 
@endsection
@section('content')


<div class="card">

    <div class="card-header">
        <form action="{{ route('medicamentosGuardar') }}" method="POST" id="formGuardar">
            @csrf
            <input type="hidden" name="insumo" value="{{ $insumo->id }}" required>
            <label for="nombre">Nombre de medicamento<i class="text-danger">*</i></label>
            <div class="input-group mb-3">
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Guardar</button>
                </div>
            </div>
        </form>
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
{{-- validate --}}
<script src="{{ asset('admin/plus/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plus/validate/messages_es.min.js') }}"></script>
@endpush

@prepend('linksPie')
 
    
    <script type="text/javascript">
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuMedicamentosInsumos').addClass('active');

        $( "#formGuardar" ).validate({
            rules: {
                nombre: {
                    required: true,
                    maxlength: 191
                }
            },
        });

        function eliminar(arg){
            var url="{{ route('eliminarMedicamento') }}";
            var id=$(arg).data('id');
            swal({
                title: "¿Estás seguro?",
                text: "Que desea eliminar el medicamento.!",
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
                $.post( url, { medi: id })
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
