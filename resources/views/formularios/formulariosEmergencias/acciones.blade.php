<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	<a href="{{ route('informacion-formulario',$formulario->id ) }}" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Información {{ $formulario->emergencia->nombre }}">
        <i class="fas fa-eye"></i>
    </a>
   
    @can('editarFormulario', $formulario)
    <a  href="{{ route('editar-formulario',$formulario->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $formulario->emergencia->nombre }}">
        <i class="fas fa-edit"></i>
    </a>        
    @endcan
    <a  href="{{ route('atenciones', $formulario->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar {{ $formulario->emergencia->nombre }}">
        <i class="icon-truck "></i>
    </a>
    
</div>