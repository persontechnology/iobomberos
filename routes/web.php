<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    //return view('welcome');
    #$A=Artisan::call('cache:clear');
    #$A=Artisan::call('config:clear');
    #$A=Artisan::call('config:cache');
    #$A=Artisan::call('storage:link');
    #$A=Artisan::call('key:generate');
    #$A=Artisan::call('migrate --seed');
});

Auth::routes(['verify' => true]);
Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/verificar-email-de-registro', 'HomeController@verificarEmail')->name('verificarEmail');

    //A:Deivid
    //D. roles y permisos de sistema solo acesso Administrador
    Route::namespace('Sistema')->group(function () {
        // roles
        Route::get('/roles', 'Roles@index')->name('roles');
        Route::post('/roles-guardar', 'Roles@guardar')->name('guardarRol');
        Route::post('/roles-eliminar', 'Roles@eliminar')->name('eliminarRol');
        // permisos
        Route::get('/permisos/{idRol}', 'Permisos@index')->name('permisos');
        Route::post('/permisos-sincronizar', 'Permisos@sincronizar')->name('sincronizarPermiso');
    });


    Route::namespace('Usuario')->group(function () {
        // Usuarios
        Route::get('/usuarios', 'Usuarios@index')->name('usuarios');
        Route::get('/usuarios-nuevo', 'Usuarios@nuevo')->name('usuariosNuevo');
        Route::post('/usuarios-guardar', 'Usuarios@guardar')->name('guardarUsuario');
        Route::post('/usuarios-eliminar', 'Usuarios@eliminar')->name('eliminarUsuario');
        Route::get('/usuarios-editar-rol/{idUsuario}', 'Usuarios@editarRol')->name('editarRolUsuario');
        Route::post('/usuarios-actualizar-roles', 'Usuarios@actualizarRolUsuario')->name('actualizarRolUsuario');
        Route::get('/usuarios-editar/{idUsuario}', 'Usuarios@editar')->name('editarUsuario');
        Route::post('/usuarios-actualizar', 'Usuarios@actualizar')->name('actualizarUsuario');
        Route::get('/usuarios-informacion/{idUsuario}', 'Usuarios@informacion')->name('informacionUsuario');
        Route::get('/usuarios-rol/{nombreRol}', 'Usuarios@usuariosPoRol')->name('usuariosPoRol');
        Route::get('/usuarios-informacion-pdf/{idUsuario}', 'Usuarios@informacionPdf')->name('usuarioInformacionPdf');
        Route::get('/usuarios-informacion-imprimir/{idUsuario}', 'Usuarios@informacionImprimir')->name('usuarioInformacionImprimir');
        Route::get('/usuarios-importar', 'Usuarios@importar')->name('usuariosImportar');
        Route::post('/usuarios-procesar-importar', 'Usuarios@procesarImportacion')->name('procesarImportacionUsuarios');
            
    });

    //A:Fabian Lopez
    //D. administracion de estaciones
    Route::get('/estaciones', 'Estaciones@index')->name('estaciones');
    Route::get('/nuevaEstacion', 'Estaciones@nueva')->name('nuevaEstacion');
    Route::post('/guardarEstacion', 'Estaciones@guardar')->name('guardarEstacion');
    Route::get('/editarEstacion/{id}', 'Estaciones@editar')->name('editarEstacion');
    Route::post('/actualizarEstacion', 'Estaciones@actualizar')->name('actualizarEstacion');
    Route::post('/eliminarEstacion', 'Estaciones@eliminar')->name('eliminarEstacion');



});