<?php

// auth


Breadcrumbs::for('inicio', function ($trail) {
    $trail->push('Inicio', url('/'));
});
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Ingresar al sistema', route('login'));
});

Breadcrumbs::for('resetPassword', function ($trail) {
    $trail->parent('login');
    $trail->push('Restablecer contraseña', url('/password/reset'));
});
Breadcrumbs::for('register', function ($trail) {
    $trail->parent('inicio');
    $trail->push('Registrar', route('register'));
});

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Administración', route('home'));
});

//A:Deivid
//D:Breadcrums de roles y permisos
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push('Roles', route('roles'));
});
Breadcrumbs::for('permisos', function ($trail,$rol) {
    $trail->parent('roles');
    $trail->push('Permisos', route('permisos',$rol->id));
});


//A:Deivid
//D:Breadcrums de usuarios
Breadcrumbs::for('usuarios', function ($trail) {
    $trail->parent('home');
    $trail->push('G. Personal operativo', route('usuarios'));
});
Breadcrumbs::for('usuariosNuevo', function ($trail) {
    $trail->parent('usuarios');
    $trail->push('Nuevo usuario', route('usuariosNuevo'));
});
Breadcrumbs::for('informacionUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Información de usuario', route('informacionUsuario',$user->id));
});
Breadcrumbs::for('editarUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Actualizar usuario', route('editarUsuario',$user->id));
});
Breadcrumbs::for('editarRolUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Roles de usuario', route('editarRolUsuario',$user->id));
});
Breadcrumbs::for('usuariosImportar', function ($trail) {
    $trail->parent('usuarios');
    $trail->push('Importar usuarios', route('usuariosImportar'));
});

//A:Fabian Lopez
//D:Breadcrums de estaciones

Breadcrumbs::for('estaciones', function ($trail) {
    $trail->parent('home');
    $trail->push('Estaciones', route('estaciones'));
});

Breadcrumbs::for('nuevaEstacion', function ($trail) {
    $trail->parent('estaciones');
    $trail->push('Nueva estación', route('nuevaEstacion'));
});

Breadcrumbs::for('editarEstacion', function ($trail,$estacion) {
    $trail->parent('estaciones');
    $trail->push('Editar estación', route('editarEstacion',$estacion->id));
});

//A:Fabian Lopez
//D:Breadcrums de emergencias
Breadcrumbs::for('emergencias', function ($trail) {
    $trail->parent('home');
    $trail->push('Emergencias', route('emergencia'));
});

Breadcrumbs::for('editarEmergencia', function ($trail, $emergencia) {
    $trail->parent('emergencias');
    $trail->push('Editar Emergencia', route('editarEmergencia',$emergencia->id));
});


//A:Fabian Lopez
//D:Breadcrums de Tipos emergencias

Breadcrumbs::for('tipoEmergencias', function ($trail, $emergencia) {
    $trail->parent('emergencias');
    $trail->push('Tipo Emergencia de '.$emergencia->nombre , route('tipoEmergencia',$emergencia->id));
});
Breadcrumbs::for('editarTipoEmergencias', function ($trail, $tipoEmergencia) {
    $trail->parent('tipoEmergencias',$tipoEmergencia->emergencia);
    $trail->push('Editar Tipo Emergencia', route('editarTipoEmergencia',$tipoEmergencia->id));
});