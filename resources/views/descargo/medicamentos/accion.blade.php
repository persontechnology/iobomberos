<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a href="{{ route('editarMedicamento',$medi->id) }}" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="Editar {{ $medi->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button onclick="eliminar(this);" data-id="{{ $medi->id }}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $medi->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>    
</div>