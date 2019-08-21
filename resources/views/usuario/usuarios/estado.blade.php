@if($user->estado=="Activo")
<span class="badge bg-success">Activo</span>
@endif
@if($user->estado=="Inactivo")
<span class="badge bg-warning">Inactivo</span>
@endif
@if($user->estado=="Dado de baja")
<span class="badge bg-danger">Dado de baja</span>
@endif