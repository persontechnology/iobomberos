<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	
    <a  href="{{route('editarTipoVehiculo',$vehiculo->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $vehiculo->modelo }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $vehiculo->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{$vehiculo->modelo}}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>