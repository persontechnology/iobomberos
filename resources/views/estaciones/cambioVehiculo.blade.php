@extends('layouts.app',['title'=>'Cambio Vehiculo'])
@section('breadcrumbs', Breadcrumbs::render('actualizarVehiculoEstacion'))
@section('content')
<div id="listadoVehiculo" >
</div>
<script>
         cargaListadosVehiculo();
     
</script>
@push('linksCabeza')
    <script>
        function cargaListadosVehiculo(){
            $("#listadoVehiculo" ).load("{{route('listaVehiculoEstacion')}}",function( response, status, xhr ){
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
