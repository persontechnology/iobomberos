@extends('layouts.app',['title'=>'Estaciones'])
@section('breadcrumbs', Breadcrumbs::render('estaciones'))

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
    
@endprepend

@endsection
