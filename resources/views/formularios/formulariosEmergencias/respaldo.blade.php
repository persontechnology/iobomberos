

@if ($formulario->foto)
<img src="{{ $formulario->foto }}"   class="img-fluid img-thumbnail"/>
@else
    <div class="alert alert-danger" role="alert">
      Actualice la imagen para el reporte
    </div>
@endif
