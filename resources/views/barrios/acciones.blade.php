<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a  href="{{route('editarBarrio',$barrio->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $barrio->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $barrio->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $barrio->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>