@extends('layouts.app',['title'=>'Importar puntos referencia'])

@section('breadcrumbs', Breadcrumbs::render('usuariosImportar'))

@section('content')

<form method="POST" action="{{ route('puntosGuardarImportacion') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            
            <p><strong class="text-warning">Advertencia:</strong> El archvio excel debe regirse <strong>extrictamente</strong> al formato presentado a continuación.</p>
            <p>Por favor, elimine la primera fila del encabezado, cuando vaya subir la información</p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-dark">
                        <th scope="col">Nombre de la parroquia</th>
                        <th scope="col">nombre del barrio</th>
                        <th scope="col">Nombre del punto de referencia</th>
                        <th scope="col">Latitud</th>
                        <th scope="col">longuitud</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Eloy Alfaro</td>
                        <td >El Calvario Sur</td>
                        <th scope="row">Cementerio</th>
                        <td>-0.92791753528307</td>
                        <td>-78.633389358519</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-body">
                
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecionar archivo que contenga información de usuarios</label>
                <input type="file" name="archivo" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
                
        </div>
        <div class="card-footer text-muted">
            <button type="submit" class="btn btn-dark">Importar puntos de referencia</button>
        </div>
    </div>
</form>

@push('linksCabeza')
  
@endpush

@prepend('linksPie')
    <script>
    $('#menuGestionPuntos').addClass('nav-item-expanded nav-item-open');
    $('#menuPuntosReferencia').addClass('active');
    </script>
@endprepend

@endsection
