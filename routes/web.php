<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::middleware(['auth'])->group(function(){
    //Usuarios
    Route::post('usuarios/store', 'UsuariosController@store')->name('Usuarios.store')
		->middleware('can:usuarios.create');

	Route::get('usuarios', 'UsuariosController@index')->name('Usuarios')
		->middleware('can:usuarios.index');

	Route::get('usuarios/create', 'UsuariosController@create')->name('Usuarios.create')
		->middleware('can:usuarios.create');

	Route::put('usuarios/{id}', 'UsuariosController@update')->name('Usuarios.update')
		->middleware('can:usuarios.edit');

	Route::get('usuarios/{id}', 'UsuariosController@show')->name('Usuarios.show')
		->middleware('can:usuarios.show');

	Route::delete('usuarios/{id}', 'UsuariosController@destroy')->name('Usuarios.destroy')
		->middleware('can:usuarios.destroy');

	Route::get('usuarios/{id}/edit', 'UsuariosController@edit')->name('Usuarios.edit')
		->middleware('can:usuarios.edit');
	
	// Roles
    Route::get('roles', 'RolesController@index')->name('Roles')
        ->middleware('can:roles.index');
        
    Route::get('roles/create', 'RolesController@create')->name('Roles.create')
        ->middleware('can:roles.create');

    Route::post('roles/store', 'RolesController@store')->name('Roles.store')
        ->middleware('can:roles.create');

    Route::put('roles/{id}', 'RolesController@update')->name('Roles.update')
		->middleware('can:roles.edit');

	Route::get('roles/{id}', 'RolesController@show')->name('Roles.show')
		->middleware('can:roles.show');

	Route::delete('roles/{id}', 'RolesController@destroy')->name('Roles.destroy')
		->middleware('can:roles.destroy');

	Route::get('roles/{id}/edit', 'RolesController@edit')->name('Roles.edit')
		->middleware('can:roles.edit');

	//Claves dinamicas
	Route::get('claves', 'ClavesDinamicasController@index')->name('Claves');
	Route::get('claves/generar', 'ClavesDinamicasController@create')->name('Claves.generar');
});
