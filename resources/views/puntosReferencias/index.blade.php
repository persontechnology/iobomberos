@extends('layouts.app',['title'=>'Puntos de Referencia'])
@section('breadcrumbs', Breadcrumbs::render('puntosReferencias'))

@section('barraLateral')

    <div class="breadcrumb justify-content-center">
        <a href="{{ route('puntosReferenciaNuevo') }}" class="breadcrumb-elements-item">
            <i class="fas fa-plus-circle"></i> Nuevo P. referencia
        </a>
         <a href="{{ route('puntosReferenciaMapa') }}" class="breadcrumb-elements-item">
            <i class="icon-map"></i> Ver mapa
        </a>
    </div>
@endsection
@section('content')
<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Puntos de referencia</h5>
		<div class="header-elements">
			<div class="list-icons">
        		<a class="list-icons-item" data-action="collapse"></a>
        		<a class="list-icons-item" data-action="reload"></a>        		
        	</div>
    	</div>
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
 {!! $dataTable->scripts() !!}
<script type="text/javascript">
   $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
    $('#menuPuntosReferencia').addClass('active');
</script>

@endprepend

@endsection
