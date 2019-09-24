<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

        <a href="{{ route('editarInsumo',$insumo->id) }}" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="Editar {{ $insumo->nombre }}">
            <i class="fas fa-edit"></i>
        </a>
        <button onclick="eliminar(this);" data-id="{{ $insumo->id }}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $insumo->nombre }}">
            <i class="fas fa-trash-alt"></i>
        </button>    
    </div>