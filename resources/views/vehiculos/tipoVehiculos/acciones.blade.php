
<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	<a  href="{{route('vehiculos',$tipoVehiculo->id)}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Vehículos en {{ $tipoVehiculo->nombre }}">
        <i class="icon-truck"></i>
    </a>
    <a  href="{{route('editarTipoVehiculo',$tipoVehiculo->id)}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $tipoVehiculo->nombre }}">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" onclick="eliminar(this);" data-id="{{ $tipoVehiculo->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $tipoVehiculo->nombre }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    
</div>