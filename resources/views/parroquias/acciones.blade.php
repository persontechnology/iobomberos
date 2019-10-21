<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a  href="{{route('editarParroquia',$parroquia->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $parroquia->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $parroquia->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $parroquia->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>