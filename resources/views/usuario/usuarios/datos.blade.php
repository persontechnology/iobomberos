<div class="table-responsive">
    <table class="table table-bordered">
        
        <tr>
            <th scope="row">Estado de la cuenta</th>
            <td colspan="3">
                @if($usuario->estado)
                    Activo
                @else
                    Inactivo
                @endif
            </td>
            
        </tr>
        <tr>
            <th scope="row">Usuario</th>
            <td>{{ $usuario->name }}</td>
            <th scope="row">Email</th>
            <td>{{ $usuario->email }}</td>
        </tr>
        <tr>
            <th scope="row">Creado el</th>
            <td>
                {{ $usuario->created_at }} 
                <small>{{ $usuario->created_at->diffForHumans() }}</small>
            </td>
            <th scope="row">Actualizado el</th>
            <td>
                {{ $usuario->updated_at }} 
                <small>{{ $usuario->updated_at->diffForHumans() }}</small>
            </td>
        </tr>
        <tr>
            <th scope="row">Creado por</th>
            <td>
                @if($usuario->creadoPor)
                    {{ $usuario->creadoPor($usuario->creadoPor)->email }}
                @else
                --
                @endif

            </td>
            <th scope="row">Actualizado por</th>
            <td>
                @if($usuario->actualizadoPor)
                    {{ $usuario->actualizadoPor($usuario->actualizadoPor)->email }}
                @else
                    --
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row">Email verificado</th>
            <td>
                @if($usuario->hasVerifiedEmail())
                    Verificado
                @else
                    Sin verificar
                @endif
            </td>
            <th scope="row">Fecha email verificado</th>
            <td>
                @if($usuario->hasVerifiedEmail())
                    {{ $usuario->email_verified_at }}
                    <small>{{ $usuario->email_verified_at->diffForHumans() }}</small>
                @else
                    --
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row">Roles</th>
            <td colspan="3">
                @foreach ($usuario->getRoleNames() as $rol)
                    {{ $rol }},
                @endforeach
            </td>
        </tr>

        <tr>
            <th scope="row">Permisos</th>
            <td colspan="3">
                @foreach ($usuario->getPermissionsViaRoles() as $per)
                    {{ $per->name }},
                @endforeach
            </td>
        </tr>
       
        
        
    </table>
</div>