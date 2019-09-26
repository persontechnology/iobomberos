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
    $trail->push('Nuevo personal Op.', route('usuariosNuevo'));
});
Breadcrumbs::for('informacionUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Información de personal Op.', route('informacionUsuario',$user->id));
});
Breadcrumbs::for('editarUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Actualizar personal Op.', route('editarUsuario',$user->id));
});
Breadcrumbs::for('editarRolUsuario', function ($trail,$user) {
    $trail->parent('usuarios');
    $trail->push('Roles de personal Op.', route('editarRolUsuario',$user->id));
});
Breadcrumbs::for('usuariosImportar', function ($trail) {
    $trail->parent('usuarios');
    $trail->push('Importar personal Op.', route('usuariosImportar'));
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
Breadcrumbs::for('actualizarPersonalEstacion', function ($trail) {
    $trail->parent('estaciones');
    $trail->push('Cambio de personal', route('actualizarPersonalEstacion'));
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

//A:Fabian Lopez
//D:Breadcrums de clinicas

Breadcrumbs::for('clinicas', function ($trail) {
    $trail->parent('home');
    $trail->push('Clínicas', route('clinicas'));
});

Breadcrumbs::for('editarClinica', function ($trail,$clinica) {
    $trail->parent('clinicas');
    $trail->push('Editar clínica', route('editarClinica',$clinica->id));
});

//A:Fabian Lopez
//D:Breadcrums de punto de referencia

Breadcrumbs::for('puntosReferencias', function ($trail) {
    $trail->parent('home');
    $trail->push('Puntos de referencia', route('puntosReferencia'));
});

Breadcrumbs::for('nuevoPuntoReferencia', function ($trail) {
    $trail->parent('puntosReferencias');
    $trail->push('Nuevo punto de referencia', route('puntosReferenciaNuevo'));
});

Breadcrumbs::for('mapaPuntoReferencia', function ($trail) {
    $trail->parent('puntosReferencias');
    $trail->push('Mapa punto de referencia', route('puntosReferenciaMapa'));
});
Breadcrumbs::for('editarPuntoReferencia', function ($trail,$puntosReferencia) {
    $trail->parent('puntosReferencias');
    $trail->push('Editar punto de referencia', route('editarReferencia',$puntosReferencia->id));
});

//A:Fabian Lopez
//D:Breadcrums de tipos de vehículo

Breadcrumbs::for('tipoVehiculo', function ($trail) {
    $trail->parent('home');
    $trail->push('Tipos de vehículo', route('tipoVehiculos'));
});
Breadcrumbs::for('editarTipoVehiculo', function ($trail,$tipoVehiculo) {
    $trail->parent('tipoVehiculo');
    $trail->push('Editar tipo vehículo', route('editarTipoVehiculo',$tipoVehiculo->id));
});
Breadcrumbs::for('importarVehiculos', function ($trail) {
    $trail->parent('tipoVehiculo');
    $trail->push('Importar vehículos', route('importarVehiculos'));
});

//A:Fabian Lopez
//D:Breadcrums vehículo

Breadcrumbs::for('vehiculos', function ($trail,$tipoVehiculo) {
    $trail->parent('tipoVehiculo');
    $trail->push('Vehículos', route('vehiculos',$tipoVehiculo->id));
});

Breadcrumbs::for('nuevoVehiculos', function ($trail,$tipoVehiculo) {
    $trail->parent('vehiculos',$tipoVehiculo);
    $trail->push('Nuevo vehículos', route('nuevoVehiculo',$tipoVehiculo->id));
});
Breadcrumbs::for('editarVehiculo', function ($trail,$vehiculo) {
    $trail->parent('vehiculos',$vehiculo->tipoVehiculo);
    $trail->push('Editar vehículo', route('editarVehiculo',$vehiculo->id));
});



// A:D.criollo
// D:descargos de insumos y medicamentos
// insumos

Breadcrumbs::for('insumos', function ($trail) {
    $trail->parent('home');
    $trail->push('Insumos', route('insumos'));
});
Breadcrumbs::for('editarInsumo', function ($trail,$insumo) {
    $trail->parent('insumos');
    $trail->push('Editar insumo', route('editarInsumo',$insumo->id));
});
// medicamentos
Breadcrumbs::for('medicamentos', function ($trail,$insumo) {
    $trail->parent('insumos');
    $trail->push('Medicamentos en '.$insumo->nombre, route('medicamentos',$insumo->id));
});
Breadcrumbs::for('editarMedicamento', function ($trail,$medi) {
    $trail->parent('medicamentos',$medi->insumo);
    $trail->push('Editar medicamento', route('editarMedicamento',$medi->id));
});


// GENERAR ASISTENCIA


Breadcrumbs::for('generarAsistencia', function ($trail) {
    $trail->parent('home');
    $trail->push('Generar asistencia', route('generarAsistencia'));
});

Breadcrumbs::for('listadoPersonalAsistencia', function ($trail,$estacion) {
    $trail->parent('generarAsistencia');
    $trail->push('Listado de personal en '.$estacion->nombre, route('listadoPersonalAsistencia',$estacion->id));
});


