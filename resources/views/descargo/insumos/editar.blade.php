@extends('layouts.app',['title'=>'Insumos'])
@section('breadcrumbs', Breadcrumbs::render('editarInsumo',$insumo))
@section('barraLateral')

@endsection
@section('content')


<div class="card">

    <div class="card-header">
        <form action="{{ route('insumosActualizar') }}" method="POST" id="formGuardar">
            @csrf
            <input type="hidden" name="insumo" value="{{ $insumo->id }}" required>
            <label for="nombre">Nombre de insumo<i class="text-danger">*</i></label>
            <div class="input-group mb-3">
                <input type="text" name="nombre" value="{{ old('nombre',$insumo->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingrese nombre.." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-dark" type="submit">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
       
    </div>
</div>

@push('linksCabeza')

@endpush

@prepend('linksPie')
  <script type="text/javascript">
       $('#menuGestionInformacion').addClass('nav-item-expanded nav-item-open');
        $('#menuMedicamentosInsumos').addClass('active');
  </script>
    
    
@endprepend

@endsection
