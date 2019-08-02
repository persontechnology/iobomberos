<?php

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


//A:Fabian Lopez
//D:Breadcrums de estaciones

Breadcrumbs::for('estaciones', function ($trail) {
    $trail->parent('home');
    $trail->push('Estaciones', route('estaciones'));
});

