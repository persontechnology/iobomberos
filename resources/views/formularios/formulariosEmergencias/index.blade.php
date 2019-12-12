@extends('layouts.app',['title'=>'formularios'])

@section('breadcrumbs', Breadcrumbs::render('formularios'))

@section('barraLateral')

@endsection

@section('content')
<div class="card">
    <div class="card-header">       
            <label for="nombre">Administración de formularios</label>         
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
@endpush

@prepend('linksPie')
<script type="text/javascript">
    $('#menuGestionFomularios').addClass('nav-item-expanded nav-item-open');
     $('#menuFormularios').addClass('active');
</script>
 {!! $dataTable->scripts() !!}
 <script>
function cambiarProceso(arg){
        
        swal({
            title: "¿Estás seguro?",
            text: "Que desea cambiar de estado el formulario !",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-dark",
            cancelButtonClass: "btn-danger",
            confirmButtonText: "¡Sí, cambiar!",
            cancelButtonText:"Cancelar",
            closeOnConfirm: false
        },
        function(){
            swal.close();
            $.blockUI({message:'<h1>Espere por favor.!</h1>'});
            $.post( "{{ route('cambio-proceso-formulario') }}", { formulario: $(arg).data('id') })
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
@endprepend

@endsection