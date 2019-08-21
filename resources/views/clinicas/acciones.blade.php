<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    <a  href="{{route('editarClinica',$clinica->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $clinica->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $clinica->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $clinica->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>