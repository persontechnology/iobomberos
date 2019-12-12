<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	<a href="{{ route('informacion-formulario',$formulario->id ) }}" class="btn btn-primary"  Cambio a proceso data-toggle="tooltip" data-placement="top" title="Información {{ $formulario->emergencia->nombre }}">
        <i class="fas fa-eye"></i>
    </a>
   
    @can('editarFormulario', $formulario)
    <a  href="{{ route('editar-formulario',$formulario->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $formulario->emergencia->nombre }}">
        <i class="fas fa-edit"></i>
    </a>        
    @endcan
    {{-- habilitar los vehiculos cuando tengan rol R.O Ope --}}
    @can('cambioEstadoProceso', $formulario)
        <button onclick="cambiarProceso(this)" data-id="{{ $formulario->id }}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Habilitar Recursos de {{ $formulario->emergencia->nombre }}"><i class="icon-bus"></i> </button>
    @endcan
    
    
</div>