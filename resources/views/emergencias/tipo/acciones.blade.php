<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a href="{{ route('editarTipoEmergencia',$teme->id) }}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Actualizar {{ $teme->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button onclick="eliminar(this);" data-id="{{ $teme->id }}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $teme->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>    
</div>