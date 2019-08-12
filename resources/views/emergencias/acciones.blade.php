<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

    <a href="{{ route('tipoEmergencia',$eme->id) }}" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Tipo de emergencia de {{ $eme->nombre }}">
        <i class="fas fa-first-aid"></i>
    </a>
    <a href="{{ route('editarEmergencia',$eme->id) }}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Actualizar {{ $eme->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button onclick="eliminar(this);" data-id="{{ $eme->id }}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $eme->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>    
</div>