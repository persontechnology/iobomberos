@extends('layouts.app',['title'=>'Importar usuarios'])

@section('breadcrumbs', Breadcrumbs::render('usuariosImportar'))

@section('content')

<form method="POST" action="{{ route('imnportarArchivoVehiculos') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            
            <p><strong class="text-warning">Advertencia:</strong> El archvio excel debe regirse <strong>extrictamente</strong> al formato presentado a continuación.</p>
            <p>Por favor, elimine la primera fila del encabezado, cuando vaya subir la información</p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-dark">
                        <th scope="col">Estación</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Código</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Cilindraje</th>
                        <th scope="col">Año</th>
                        <th scope="col">Motor</th>
                        <th scope="col">Placa</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Latacunga</td>
                        <th scope="row">Bus</th>
                        <td>1</td>
                        <td>VOLKSWAGEN</td>
                        <td>OBNIBUS</td>
                        <td>4300</td>
                        <td>2011</td>
                        <td>E1T174346</td>
                        <td>XEA0848</td>

                    </tr>
                </table>
            </div>
        </div>
        <div class="card-body">
                
            <div class="form-group">
                <label for="exampleFormControlFile1">Selecionar archivo que contenga información de usuarios</label>
                <input type="file" name="archivo" class="form-control-file" id="exampleFormControlFile1">
            </div>
                
        </div>
        <div class="card-footer text-muted">
            <button type="submit" class="btn btn-success">Importar usuarios</button>
        </div>
    </div>
</form>

@push('linksCabeza')
  
@endpush

@prepend('linksPie')
    <script>
        $('#menuUsuarios').addClass('active');
    </script>
@endprepend

@endsection
