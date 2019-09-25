@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('actualizarPersonalEstacion'))
@section('content')
<div id="listadosss" class="overflow-auto">
</div>
<script>
         cargaListadoss();
     
</script>
@push('linksCabeza')
<script>
        function cargaListadoss(){
            $("#listadosss" ).load("{{route('listaEstacion')}}",function( response, status, xhr ){
                if ( status == "error" ) {
                    notificar('warning','No se pudo cargar el listado')
                }
            }); 
        }
     
</script>
<script src="{{ asset('admin/plus/sortable/Sortable.min.js') }}"></script>


@endpush



@prepend('linksPie')
   
    <script>
        
        $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuEstacion').addClass('active');
       
    </script>
    
@endprepend
@endsection
