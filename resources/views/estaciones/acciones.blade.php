<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a  href="{{route('editarEstacion',$estacion->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $estacion->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $estacion->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $estacion->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>