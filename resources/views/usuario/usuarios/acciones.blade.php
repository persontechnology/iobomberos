<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
    
    <a href="{{asset('img/'.$user->email.'.png')}}" class="btn btn-success"  data-toggle="tooltip" data-placement="top" title="Código QR {{ $user->name }}">
        <i class="fas fa-qrcode"></i>
    </a>

    <a href="{{ route('informacionUsuario',$user->id) }}" class="btn btn-dark"  data-toggle="tooltip" data-placement="top" title="Información {{ $user->name }}">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('editarUsuario',$user->id) }}" class="btn btn-info"  data-toggle="tooltip" data-placement="top" title="Editar {{ $user->name }}">
        <i class="fas fa-edit"></i>
    </a>

    <a href="{{ route('editarRolUsuario',$user->id) }}" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Roles de {{ $user->name }}">
        <i class="fas fa-key"></i>
    </a>
    @can('eliminarUsuario', $user)
    <button onclick="eliminar(this);" data-id="{{ $user->id }}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar {{ $user->name }}">
        <i class="fas fa-trash-alt"></i>
    </button>
    @endcan

</div>