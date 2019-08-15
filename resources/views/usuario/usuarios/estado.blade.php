@if($user->estado=="Activo")
<span class="badge bg-blue">Activo</span>
@endif
@if($user->estado=="Inactivo")
<span class="badge bg-info">Inactivo</span>
@endif
@if($user->estado=="Dado de baja")
<span class="badge bg-warning">Dado de baja</span>
@endif